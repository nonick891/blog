<?php

namespace Core;

class MigrationsCommands
{
    public static function run(): void
    {
        MigrationsStorage::ensureMigrationsExists();

        $executed = MigrationsStorage::getMigrations();

        $files = self::discoverFiles();

        foreach ($files as $file) {
            $name = basename($file);

            if (in_array($name, $executed, true)) {
                continue;
            }

            self::executeMigration($file, $name);

            MigrationsStorage::saveMigration($name);

            echo "Migration $name executed successfully\n";
        }
    }

    public static function reset(): void
    {
        DB::query('SET FOREIGN_KEY_CHECKS = 0');

        foreach (DB::fetchAll('SHOW TABLES') as $row) {
            $table = current($row);

            if (!is_string($table)) {
                continue;
            }

            DB::query('DROP TABLE IF EXISTS `' . $table . '`');
        }

        DB::query('SET FOREIGN_KEY_CHECKS = 1');

        self::run();
    }

    /** @return list<string> */
    private static function discoverFiles(): array
    {
        $files = glob(dirname(__DIR__) . '/database/migrations/*.sql');

        if ($files === false) {
            throw new \RuntimeException('Failed to read migrations directory');
        }

        return $files;
    }

    /**
     * @param string $file
     * @param string $name
     */
    private static function executeMigration(string $file, string $name): void
    {
        $sql = file_get_contents($file);

        if ($sql === false) {
            throw new \RuntimeException("Failed to read migration file: $file");
        }

        try {
            DB::query($sql);
        } catch (\PDOException $e) {
            $lines = explode("\n", $sql);
            $msg = self::formatQueryError($name, $e, $lines);
            throw new \RuntimeException($msg);
        }
    }

    /**
     * @param string $name
     * @param \PDOException|\Exception $e
     * @param list<string> $queryLines
     * @return string
     */
    private static function formatQueryError(string $name, \PDOException|\Exception $e, array $queryLines): string
    {
        return sprintf(
            "SQL error in %s:\n  %s\n\n--- SQL ---\n%s\n------------",
            $name,
            $e->getMessage(),
            implode(
                "\n",
                array_map(
                    fn($i, $line) => sprintf("%3d: %s", $i + 1, $line),
                    array_keys($queryLines),
                    $queryLines
                )
            )
        );
    }
}

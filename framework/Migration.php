<?php

namespace Framework;

class Migration
{
    private const string TABLE = 'migrations';

    private const string COLUMN_NAME = 'name';

    private const string COLUMN_EXECUTED_AT = 'executed_at';

    public static function run(): void
    {
        self::ensureMigrationsExists();

        $executed = self::getMigrations();

        $files = self::discoverFiles();

        foreach ($files as $file) {
            $name = basename($file);

            if (in_array($name, $executed, true)) {
                continue;
            }

            self::executeMigration($file, $name);

            self::saveMigration($name);

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
    public static function getMigrations(): array
    {
        /** @var list<string> $migrations */
        $migrations = array_column(
            DB::fetchAll('SELECT name FROM ' . self::TABLE . ' ORDER BY executed_at DESC'),
            self::COLUMN_NAME
        );

        return $migrations;
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

    private static function ensureMigrationsExists(): void
    {
        DB::query(
            sprintf(
                "CREATE TABLE IF NOT EXISTS %s (
                  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  %s VARCHAR(255) NOT NULL UNIQUE,
                  %s TIMESTAMP DEFAULT CURRENT_TIMESTAMP
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
                self::TABLE,
                self::COLUMN_NAME,
                self::COLUMN_EXECUTED_AT
            )
        );
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
     * @return void
     */
    public static function saveMigration(string $name): void
    {
        DB::query("INSERT INTO " . self::TABLE . " (name) VALUES (:name)", ['name' => $name]);
    }
}

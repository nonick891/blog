<?php

namespace Core;

class MigrationsStorage
{
    private const string TABLE = 'migrations';

    private const string COLUMN_NAME = 'name';

    private const string COLUMN_EXECUTED_AT = 'executed_at';

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

    public static function ensureMigrationsExists(): void
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

    public static function saveMigration(string $name): void
    {
        DB::query("INSERT INTO " . self::TABLE . " (name) VALUES (:name)", ['name' => $name]);
    }
}

<?php

namespace Framework;

class Connection
{
    /** @var array<string, string> */
    private static array $config = [];

    private static ?\PDO $instance = null;

    /** @param array<string, string> $config */
    public static function getInstance(array $config = []): \PDO
    {
        if (self::$instance === null) {
            self::setConfig($config);
            $host = self::$config['DB_HOST'] ?? '127.0.0.1';
            $port = self::$config['DB_PORT'] ?? '3306';
            $dbname = self::$config['DB_NAME'];

            try {
                self::$instance = new \PDO(
                    "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4",
                    self::$config['DB_USER'],
                    self::$config['DB_PASSWORD'],
                    [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                        \PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (\PDOException $e) {
                error_log('Database connection failed: ' . $e->getMessage());
                throw new \RuntimeException('Database unavailable');
            }
        }

        return self::$instance;
    }

    /** @param array<string, string> $config */
    private static function setConfig(array $config): void
    {
        self::$config = array_merge(self::$config, $config);
    }
}

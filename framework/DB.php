<?php

namespace Framework;

class DB
{
    public static function getInstance(): \PDO
    {
        return Connection::getInstance(self::getConfig());
    }

    /** @return array<string, string> */
    private static function getConfig(): array
    {
        /** @var array<string, string>|false $confFile */
        $confFile = parse_ini_file(dirname(__DIR__) . '/.env');
        return is_array($confFile) ? $confFile : [];
    }

    /** @param array<string, mixed> $variables */
    public static function query(string $sql, array $variables = []): \PDOStatement
    {
        $stmt = self::getInstance()->prepare($sql);
        if ($stmt === false) {
            throw new \RuntimeException('Failed to prepare SQL statement');
        }
        $stmt->execute($variables);
        return $stmt;
    }

    /**
     * @param array<string, mixed> $variables
     * @return array<string, mixed>
     */
    public static function fetch(string $sql, array $variables = []): array
    {
        $stmt = self::query($sql, $variables);
        /** @var array<string, mixed>|false $result */
        $result = $stmt->fetch();
        return is_array($result) ? $result : [];
    }

    /**
     * @param array<string, mixed> $variables
     * @return list<array<string, mixed>>
     */
    public static function fetchAll(string $sql, array $variables = []): array
    {
        $stmt = self::query($sql, $variables);
        /** @var list<array<string, mixed>> $result */
        $result = $stmt->fetchAll();
        return $result;
    }
}

<?php

namespace Core;

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

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public static function insert(string $table, array $data): array
    {
        self::insertBatch($table, [$data]);

        $id = self::getInstance()->lastInsertId();

        if ($id === false) {
            throw new \RuntimeException('Failed to retrieve last insert ID');
        }

        if ($id === '0') {
            return $data;
        }

        return self::fetch("SELECT * FROM $table WHERE id = :id", ['id' => $id]);
    }

    /**
     * @param list<array<string, mixed>> $rows
     */
    public static function insertBatch(string $table, array $rows): void
    {
        if ($rows === []) {
            return;
        }

        $columns = implode(', ', array_keys($rows[0]));
        $allPlaceholders = [];
        $params = [];

        foreach ($rows as $i => $row) {
            $rowPlaceholders = array_map(fn(string $col) => ":{$col}_{$i}", array_keys($row));
            $allPlaceholders[] = '(' . implode(', ', $rowPlaceholders) . ')';
            foreach ($row as $col => $value) {
                $params["{$col}_{$i}"] = $value;
            }
        }

        self::query(
            "INSERT INTO $table ($columns) VALUES " . implode(', ', $allPlaceholders),
            $params
        );
    }
}

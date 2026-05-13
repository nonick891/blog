<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\MigrationsCommands;

$command = $argv[1] ?? 'migrate';
try {
    match ($command) {
        'migrate' => MigrationsCommands::run(),
        'reset' => MigrationsCommands::reset(),
        default => throw new \InvalidArgumentException("Unknown command: $command. Use 'migrate' or 'reset'."),
    };
} catch (\Throwable $e) {
    fwrite(STDERR, "\033[31mError:\033[0m " . $e->getMessage() . "\n\n");
    fwrite(STDERR, "File: " . $e->getFile() . ":" . $e->getLine() . "\n");
    exit(1);
}

<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Framework\Migration;

$command = $argv[1] ?? 'run';
try {
    match ($command) {
        'run' => Migration::run(),
        'reset' => Migration::reset(),
        default => throw new \InvalidArgumentException("Unknown command: $command. Use 'run' or 'reset'."),
    };
} catch (\Throwable $e) {
    fwrite(STDERR, "\033[31mError:\033[0m " . $e->getMessage() . "\n\n");
    fwrite(STDERR, "File: " . $e->getFile() . ":" . $e->getLine() . "\n");
    exit(1);
}

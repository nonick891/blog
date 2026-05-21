<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Cli\Command;

$command = Command::tryFrom($argv[1] ?? '');

try {
    if ($command === null) {
        $commands = implode(', ', array_map(fn(Command $c) => "'{$c->value}'", Command::cases()));
        throw new \InvalidArgumentException("Unknown command. Use: $commands");
    }

    $command->run();
} catch (\Throwable $e) {
    fwrite(STDERR, "\033[31mError:\033[0m " . $e->getMessage() . "\n\n");
    fwrite(STDERR, "File: " . $e->getFile() . ":" . $e->getLine() . "\n");
    exit(1);
}

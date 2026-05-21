<?php

namespace Core\Cli;

enum Command: string
{
    case Migrate = 'migrate';
    case Reset = 'reset';
    case Seed = 'seed';
    case Refresh = 'refresh';
    case Truncate = 'truncate';

    public function run(): void
    {
        match ($this) {
            Command::Migrate => MigrationsCommands::run(),
            Command::Reset => MigrationsCommands::reset(),
            Command::Seed => SeederCommands::run(),
            Command::Refresh => (function () {
                MigrationsCommands::reset();
                SeederCommands::run();
            })(),
            Command::Truncate => SeederCommands::truncate(),
        };
    }
}

<?php

namespace app\supportBot;

use app\bot\Bot;
use app\supportBot\commands\{StartCommand, CallsCommand, HelpCommand, SupportCommand};


class SupportBot extends Bot
{
    private static $_commands = [
        'start' => StartCommand::class,
        'calls' => CallsCommand::class,
        'help' => HelpCommand::class,
        'support' => SupportCommand::class,
    ];

    public static function getCommands(): array
    {
        return self::$_commands;
    }
}
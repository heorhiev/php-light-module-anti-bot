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


    public static function getMenu(): array
    {
        return [
            self::$_commands['calls'],
            self::$_commands['help'],
            self::$_commands['support'],
        ];
    }


    public static function getVewPath(string $view): string
    {
        return '{@vendorPath}/heorhiev/php-app-support-bot/src/views/' . $view;
    }
}
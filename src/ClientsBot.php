<?php

namespace app\clientsBot;

use app\bot\Bot;
use app\clientsBot\commands\{
    StartCommand,
    BirthdayCommand,
    NameCommand,
    PhoneCommand,
    NotifyCommand,
};


class ClientsBot extends Bot
{
    private static $_commands = [
        'start' => StartCommand::class,
        'birthday' => BirthdayCommand::class,
        'name' => NameCommand::class,
        'phone' => PhoneCommand::class,
        'notify' => NotifyCommand::class,
    ];

    public static function getCommands(): array
    {
        return self::$_commands;
    }
}
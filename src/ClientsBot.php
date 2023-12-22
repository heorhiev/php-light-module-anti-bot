<?php

namespace app\clientsBot;

use app\bot\Bot;
use app\clientsBot\entities\Contact;
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


    public function getStoredCommand(): ?string
    {
        $contact = Contact::repository()->findById($this->getUserId())->asEntityOne();
        return $contact ? $contact->command : null;
    }


    public function storeCommand($command): bool
    {
        return Contact::repository()->update(
            ['command' => $command],
            ['id' => $this->getUserId()]
        );
    }

    public static function getCommands(): array
    {
        return self::$_commands;
    }
}
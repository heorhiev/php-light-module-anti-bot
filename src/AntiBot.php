<?php

namespace light\module\antiBot;

use light\tg\bot\Bot;
use light\module\antiBot\entities\User;
use light\module\antiBot\commands\{ShareUserCommand, StartCommand};


class AntiBot extends Bot
{
    private static $_commands = [
        'start' => StartCommand::class,
        'share_user' => ShareUserCommand::class,
    ];


    public function getStoredCommand(): ?string
    {
        $user = User::repository()->findById($this->getUserId())->asEntityOne();
        return $user ? $user->command : null;
    }


    public function storeCommand($command): bool
    {
        return User::repository()->update(
            ['command' => $command],
            ['id' => $this->getUserId()]
        );
    }

    public static function getCommands(): array
    {
        return self::$_commands;
    }
}
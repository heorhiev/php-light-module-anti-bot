<?php

namespace light\module\antiBot;

use light\tg\bot\Bot;
use light\module\antiBot\entities\User;
use light\module\antiBot\commands\{AddReviewCommand, GetReviewCommand, StartCommand, HelpCommand};


class AntiBot extends Bot
{
    private static $_commands = [
        'start' => StartCommand::class,
        'add_review' => AddReviewCommand::class,
        'get_review' => GetReviewCommand::class,
        'help' => HelpCommand::class,
    ];


    public function getStoredCommand(): ?string
    {
        $user = User::repository()->findById($this->getUserId())->asEntityOne();
        return $user?->command;
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
<?php

namespace app\supportBot;

use app\bot\Bot;
use app\supportBot\commands\StartCommand;
use app\supportBot\commands\MessageCommand;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Message;


class SupportBot extends Bot
{
    public function handler(): void
    {
        $this->getBot()->command('start', function(Message $message) {
            (new StartCommand($this, $message))->run();
        });

        //Handle text messages
        $this->getBot()->on(function (\TelegramBot\Api\Types\Update $update) {
            (new MessageCommand($this, $update->getMessage()))->run();
        }, function () {
            return true;
        });

        $this->getBot()->run();
    }


    public static function getVewPath(string $view): string
    {
        return '{@vendorPath}/heorhiev/php-app-support-bot/src/views/' . $view;
    }
}
<?php

namespace light\module\antiBot\controllers\http;

use light\module\antiBot\AntiBot;
use light\http\ControllerInterface;


class AntiBotController implements ControllerInterface
{
    public function main(): void
    {
        $bot = new AntiBot('anti/telegram');
        $bot->run();
    }
}
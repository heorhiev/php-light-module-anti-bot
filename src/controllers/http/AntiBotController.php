<?php

namespace light\module\antiBot\controllers\http;

use light\module\antiBot\AntiBot;
use light\http\ControllerInterface;


class AntiBotController implements ControllerInterface
{
    public function main(): void
    {
        (new AntiBot('anti/telegram'))->run();
    }
}
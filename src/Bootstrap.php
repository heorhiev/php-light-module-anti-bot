<?php

namespace light\module\antiBot;

use light\module\antiBot\controllers\http\ClientsBotController;
use light\app\BootstrapInterface;
use light\http\Http;


class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        Http::addRoute('clients-bot-handler', ClientsBotController::class);
    }
}

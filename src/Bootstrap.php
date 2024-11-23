<?php

namespace light\module\antiBot;

use light\app\services\AliasService;
use light\module\antiBot\controllers\http\AntiBotController;
use light\app\BootstrapInterface;
use light\http\Http;


class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        Http::addRoute('anti-bot-handler', AntiBotController::class);
        AliasService::setPath('{@antiBotViews}', __DIR__ . '/views');
    }
}

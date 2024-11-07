<?php

namespace app\antiBot;

use app\antiBot\controllers\http\ClientsBotController;
use app\toolkit\components\Route;
use light\app\BootstrapInterface;


class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        Route::add([
            'clients-bot-handler' => ClientsBotController::class,
        ]);
    }
}

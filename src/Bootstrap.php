<?php

namespace app\clientsBot;

use app\clientsBot\controllers\http\ClientsBotController;
use app\toolkit\components\bootstrap\BootstrapInterface;
use app\toolkit\components\Route;


class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        Route::add([
            'clients-bot-handler' => ClientsBotController::class,
        ]);
    }
}

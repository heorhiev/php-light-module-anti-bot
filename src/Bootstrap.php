<?php

namespace app\supportBot;

use app\supportBot\controllers\http\SupportBotController;
use app\toolkit\components\bootstrap\BootstrapInterface;
use app\toolkit\components\Route;


class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Route::add([
            'support-bot-handler' => SupportBotController::class,
        ]);
    }
}

<?php

namespace app\clientsBot\controllers\http;

use app\clientsBot\ClientsBot;


class ClientsBotController implements \app\toolkit\components\controllers\HttpControllerInterface
{
    public function main(): void
    {
        (new ClientsBot('clients/telegram'))->run();
    }
}
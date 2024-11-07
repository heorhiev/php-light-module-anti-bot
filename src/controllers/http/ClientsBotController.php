<?php

namespace app\antiBot\controllers\http;

use app\antiBot\ClientsBot;
use light\http\ControllerInterface;


class ClientsBotController implements ControllerInterface
{
    public function main(): void
    {
        (new ClientsBot('clients/telegram'))->run();
    }
}
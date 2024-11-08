<?php

namespace light\module\antiBot\controllers\http;

use light\module\antiBot\ClientsBot;
use light\http\ControllerInterface;


class ClientsBotController implements ControllerInterface
{
    public function main(): void
    {
        (new ClientsBot('clients/telegram'))->run();
    }
}
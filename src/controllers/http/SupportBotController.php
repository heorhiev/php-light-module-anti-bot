<?php

namespace app\supportBot\controllers\http;

use app\supportBot\SupportBot;


class SupportBotController implements \app\toolkit\components\controllers\HttpControllerInterface
{
    public function main()
    {
        (new SupportBot('support/telegram'))->handler();
    }
}
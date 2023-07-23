<?php

namespace app\supportBot\commands;

use app\bot\models\Message;


class StartCommand extends \app\bot\models\Command
{
    public function run(): void
    {
        $message = new Message($this->getBot()->getOptions());
        $message->setMessageView('start');
        $this->getBot()->sendMessage($message);
    }
}
<?php

namespace light\module\antiBot\commands;


class HelpCommand extends \light\tg\bot\models\Command
{
    public function run(): void
    {
        $message = $this->getBot()->getNewMessage();

        $message->setMessageView('{@antiBotViews}/help');

        $this->getBot()->sendMessage($message);
    }
}
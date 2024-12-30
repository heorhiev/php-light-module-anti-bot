<?php

namespace light\module\antiBot\commands;


use light\i18n\Loco;

class HelpCommand extends \light\tg\bot\models\Command
{
    public static function getTitle(): string
    {
        return Loco::translate('Help');
    }


    public function run(): void
    {
        $message = $this->getBot()->getNewMessage();

        $message->setMessageView('{@antiBotViews}/help');

        $this->getBot()->sendMessage($message);
    }
}
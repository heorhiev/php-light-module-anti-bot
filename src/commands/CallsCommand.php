<?php

namespace app\supportBot\commands;

use app\toolkit\services\SettingsService;
use app\supportBot\config\DataDto;


class CallsCommand extends \app\bot\models\Command
{
    private static $_options;

    public function run(): void
    {
        $message = $this->getBot()->getNewMessage()->setMessageView('calls');
        $this->getBot()->sendMessage($message);

        $calls = $this->getOptions()->data;

        foreach ($calls as $call) {
            $this->getBot()->getBotApi()->sendAudio(
                $this->getBot()->getIncomeMessage()->getSenderId(),
                $call['url']
            );
        }
    }


    private static function getOptions()
    {
        if (empty(self::$_options)) {
            self::$_options = SettingsService::load('support/calls', DataDto::class);
        }

        return self::$_options;
    }
}
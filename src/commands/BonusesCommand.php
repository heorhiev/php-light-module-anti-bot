<?php

namespace app\supportBot\commands;

use app\bot\models\Message;
use app\toolkit\services\SettingsService;
use app\supportBot\config\DataDto;


class BonusesCommand extends \app\bot\models\Command
{
    private static $_options;


    public function run(): void
    {
        $bonus = $this->getBot()->getIncomeMessage()->getParams();

        if (empty($bonus)) {
            $this->start();
        } else {
            $this->showBonus($bonus);
        }
    }


    private function start()
    {
        $message = $this->getBot()->getNewMessage()->setMessageView('bonuses');

        foreach (self::getOptions()->data as $bonus) {
            $buttons[] = [[
                'text' => $bonus['text'],
                'callback_data' => $bonus['command']
            ]];
        }

        if (isset($buttons)) {
            $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($buttons);
            $message->setKeyboardMarkup($keyboard);
        }

        $this->getBot()->sendMessage($message);
    }


    private function showBonus($bonus)
    {
        $bonusData = self::getOptions()->data[$bonus];

        $message = $this->getBot()->getNewMessage()->setMessageText($bonusData['text'], false, false);
        $this->getBot()->sendMessage($message);

        $this->getBot()->getBotApi()->sendVideo(
            $this->getBot()->getUserId(),
            $bonusData['video_url']
        );

        $this->getBot()->answerCallbackQuery();
    }


    private static function getOptions()
    {
        if (empty(self::$_options)) {
            self::$_options = SettingsService::load('support/bonuses', DataDto::class);
        }

        return self::$_options;
    }
}
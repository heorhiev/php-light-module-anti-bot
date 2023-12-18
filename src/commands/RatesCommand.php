<?php

namespace app\supportBot\commands;

use app\bot\models\Message;
use app\toolkit\services\SettingsService;
use app\bot\config\TelegramDto;
use app\supportBot\config\DataDto;


class RatesCommand extends \app\bot\models\Command
{
    private static $_options;


    public function run(): void
    {
        $rate = $this->getBot()->getIncomeMessage()->getParams();

        if (empty($rate)) {
            $this->start();
        } else {
            $this->showRate($rate);
        }
    }


    private function start()
    {
        $message = $this->getBot()->getNewMessage()->setMessageView('rates');

        foreach (self::getOptions()->data as $rate) {
            $buttons[] = [[
                'text' => $rate['text'],
                'callback_data' => $rate['command']
            ]];
        }

        if (isset($buttons)) {
            $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($buttons);
            $message->setKeyboardMarkup($keyboard);
        }

        $this->getBot()->sendMessage($message);
    }


    private function showRate($rate)
    {
        $rateData = self::getOptions()->data[$rate];

        $message = $this->getBot()->getNewMessage()->setMessageText($rateData['text']);
        $this->getBot()->sendMessage($message);

        $this->getBot()->getBotApi()->sendPhoto(
            $this->getBot()->getUserId(),
            $rateData['image_url']
        );
    }


    private static function getOptions()
    {
        if (empty(self::$_options)) {
            self::$_options = SettingsService::load('support/rates', DataDto::class);
        }

        return self::$_options;
    }
}
<?php

namespace app\antiBot\commands;

use light\tg\bot\models\Message;
use app\antiBot\constants\BotConst;
use app\antiBot\entities\Contact;
use app\antiBot\helpers\MenuHelper;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;


class StartCommand extends \light\tg\bot\models\Command
{
    public function run(): void
    {
        self::createContact($this->getBot()->getUserId());

        $message = $this->getBot()->getNewMessage();

        $message->setKeyboardMarkup(MenuHelper::getKeyboardMarkup($this->getBot()->getMenu()));

//        foreach ($menu as $command => $text) {
//            $buttons[] = [[
//                'text' => $text,
//                'callback_data' => $command
//            ]];
//        }
//
//        $message->setKeyboardMarkup($buttons);

        $message->setMessageView('start');

        $this->getBot()->sendMessage($message);
    }


    private static function createContact($userId): void
    {
        Contact::repository()->delete(['id' => $userId]);

        Contact::repository()->create([
            'id' => $userId,
            'status' => BotConst::CONTACT_STATUS_ACTIVE,
        ]);
    }
}
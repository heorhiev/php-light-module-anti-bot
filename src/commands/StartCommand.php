<?php

namespace app\clientsBot\commands;

use app\bot\models\Message;
use app\clientsBot\constants\ClientsBotConst;
use app\clientsBot\entities\Contact;
use app\clientsBot\helpers\MenuHelper;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;


class StartCommand extends \app\bot\models\Command
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
            'status' => ClientsBotConst::CONTACT_STATUS_ACTIVE,
        ]);
    }
}
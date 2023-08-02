<?php

namespace app\supportBot\commands;

use app\bot\models\Message;
use app\supportBot\constants\SupportBotConst;
use app\supportBot\entities\Contact;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;


class StartCommand extends \app\bot\models\Command
{
    public function run(): void
    {
        self::createContact($this->getBot()->getUserId());

        $message = $this->getBot()->getNewMessage();

        $menu = $this->getBot()->getMenu();

        $buttons  = [];
        foreach ($menu as $command => $text) {
            $buttons[] = [['text' => $text, 'callback_data' => $command]];
        }

//        $keyboard = new ReplyKeyboardMarkup($buttons, false, true, true);

        $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(
            [
                [
                    ['text' => $menu['rates'], 'callback_data' => 'rates'],
                    ['text' => $menu['calls'], 'callback_data' => 'calls'],
                    ['text' => $menu['bonuses'], 'callback_data' => 'bonuses'],
                ],
                [
                    ['text' => $menu['cases'], 'callback_data' => 'cases'],
                    ['text' => $menu['indicators'], 'callback_data' => 'indicators'],
                ],
                [
                    ['text' => $menu['support'], 'callback_data' => 'support']
                ]
            ],
            false,
            true,
            true
        );

        $message->setKeyboardMarkup($keyboard);

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


    private static function createContact($userId)
    {
        Contact::repository()->delete(['id' => $userId]);

        Contact::repository()->create([
            'id' => $userId,
            'status' => SupportBotConst::CONTACT_STATUS_ACTIVE,
        ]);
    }
}
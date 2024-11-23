<?php

namespace light\module\antiBot\commands;

use light\module\antiBot\constants\BotConst;
use light\module\antiBot\entities\Contact;
use light\module\antiBot\helpers\MenuHelper;


class StartCommand extends \light\tg\bot\models\Command
{
    public function run(): void
    {
        self::createContact($this->getBot()->getUserId());

        $message = $this->getBot()->getNewMessage();

        $menu = $this->getBot()->getMenu();
        if ($menu) {
            $message->setKeyboardMarkup(MenuHelper::getKeyboardMarkup($menu));
        }

        $message->setMessageView('{@antiBotViews}/start');

        $this->getBot()->sendMessage($message);
    }


    private static function createContact($userId): void
    {
        return;
        Contact::repository()->delete(['id' => $userId]);

        Contact::repository()->create([
            'id' => $userId,
            'status' => BotConst::CONTACT_STATUS_ACTIVE,
        ]);
    }
}
<?php

namespace light\module\antiBot\commands;

use light\module\antiBot\constants\BotConst;
use light\module\antiBot\entities\User;
use light\module\antiBot\helpers\MenuHelper;


class StartCommand extends \light\tg\bot\models\Command
{
    public function run(): void
    {
        self::createUser($this->getBot()->getUserId());

        $message = $this->getBot()->getNewMessage();

        $menu = $this->getBot()->getMenu();
        if ($menu) {
            $message->setKeyboardMarkup(MenuHelper::getKeyboardMarkup($menu));
        }

        $message->setMessageView('{@antiBotViews}/start');

        $this->getBot()->sendMessage($message);
    }


    private static function createUser($userId): void
    {
        User::repository()->delete(['id' => $userId]);

        User::repository()->create([
            'id' => $userId,
            'status' => BotConst::USER_STATUS_ACTIVE,
        ]);
    }
}
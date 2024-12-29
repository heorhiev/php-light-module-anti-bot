<?php

namespace light\module\antiBot\helpers;

use light\module\antiBot\entities\UserRequest;
use light\tg\bot\config\MenuDto;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;


class MenuHelper
{
    /**
     * @param MenuDto[] $menu
     */
    public static function getKeyboardMarkup(int $userId, array $menu): ReplyKeyboardMarkup
    {
        $buttons = [];

        foreach ($menu as $item) {

            $button = ['text' => $item->label];

            if ($item->is_request_user)  {
                $requestId = UserRequest::repository()->getIdOrCreate([
                    'user_id' =>  $userId,
                    'command' => $item->code,
                ]);

                $button['request_users'] = ['request_id' => $requestId];
            }

            $buttons[] = $button;
        }

        return new ReplyKeyboardMarkup([$buttons], false, true, true);
    }
}
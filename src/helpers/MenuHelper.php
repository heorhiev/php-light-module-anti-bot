<?php

namespace light\module\antiBot\helpers;

use light\tg\bot\config\MenuDto;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;


class MenuHelper
{
    /**
     * @param MenuDto[] $menu
     */
    public static function getKeyboardMarkup(array $menu): ReplyKeyboardMarkup
    {
        $buttons = [];

        foreach ($menu as $item) {

            $button = ['text' => $item->label];

            if ($item->is_request_user)  {
                $button['request_users'] = ['request_id' => rand(0, 9999)];
            }

            $buttons[] = $button;
        }

        return new ReplyKeyboardMarkup([$buttons], false, true, true);
    }
}
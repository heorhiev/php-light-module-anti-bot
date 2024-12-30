<?php

namespace light\module\antiBot\helpers;

use light\module\antiBot\entities\UserRequest;
use light\tg\bot\config\MenuDto;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use light\i18n\Loco;


class MenuHelper
{
    /**
     * @param MenuDto[] $menu
     */
    public static function getDefaultMenuKeyboard(int $userId, array $menu): ReplyKeyboardMarkup
    {
        $buttons = [];

        foreach ($menu as $item) {

            $button = ['text' => Loco::translate($item->label)];

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

//    public static function getCancelMenuKeyboard(): InlineKeyboardMarkup
//    {
//        return new InlineKeyboardMarkup(
//            [[['text' => Loco::translate('Cancel'), 'callback_data' => '/cancel']]]
//        );
//    }

    public static function getCancelMenuKeyboard(): ReplyKeyboardMarkup
    {
        $buttons[] = ['text' => Loco::translate('Cancel')];
        return new ReplyKeyboardMarkup([$buttons], true, true, true);
    }
}
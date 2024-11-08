<?php

namespace light\module\antiBot\helpers;


use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class MenuHelper
{
    public static function getKeyboardMarkup(array $menu): ReplyKeyboardMarkup
    {
        $buttons  = [];
        foreach ($menu as $command => $text) {
            $buttons[] = ['text' => $text, 'callback_data' => $command];
        }

        return new ReplyKeyboardMarkup([$buttons], false, true, true);
    }
}
<?php

namespace app\supportBot;

use app\bot\Bot;
use app\supportBot\commands\{
    StartCommand,
    CallsCommand,
    RatesCommand,
    SupportCommand,
    SupportCloseCommand,
    MessageCommand,
    NotifyCommand,
    BonusesCommand,
    CasesCommand,
    IndicatorsCommand,
};


class SupportBot extends Bot
{
    private static $_commands = [
        'start' => StartCommand::class,
        'calls' => CallsCommand::class,
        'rates' => RatesCommand::class,
        'support' => SupportCommand::class,
        'bonuses' => BonusesCommand::class,
        'cases' => CasesCommand::class,
        'indicators' => IndicatorsCommand::class,
        'notify' => NotifyCommand::class,
        'support_close' => SupportCloseCommand::class,
    ];

    public static function getCommands(): array
    {
        return self::$_commands;
    }


    public function getTextHandler($text)
    {
        $class = parent::getTextHandler($text);

        if (!$class) {
            $class = MessageCommand::class;
        }

        return $class;
    }
}
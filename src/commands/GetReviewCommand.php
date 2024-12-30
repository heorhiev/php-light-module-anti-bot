<?php

namespace light\module\antiBot\commands;



use light\i18n\Loco;

class GetReviewCommand extends \light\tg\bot\models\Command
{
    public static function getTitle(): string
    {
        return Loco::translate('Get the review');
    }

    public function run(): void
    {

    }
}
<?php

namespace app\supportBot\commands;

use app\supportBot\config\DataDto;
use app\toolkit\services\SettingsService;



class IndicatorsCommand extends \app\bot\models\Command
{
    private static $_options;

    public function run(): void
    {
        $images = self::getOptions()->data['images'];

        $media = new \TelegramBot\Api\Types\InputMedia\ArrayOfInputMedia();

        foreach ($images as $image) {
            $media->addItem(new \TelegramBot\Api\Types\InputMedia\InputMediaPhoto($image));
        }

        $this->getBot()->getBotApi()->sendMediaGroup($this->getBot()->getUserId(), $media);
    }


    private static function getOptions()
    {
        if (empty(self::$_options)) {
            self::$_options = SettingsService::load('support/indicators', DataDto::class);
        }

        return self::$_options;
    }
}
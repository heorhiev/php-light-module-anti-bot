<?php

namespace app\clientsBot\commands;

use app\clientsBot\entities\Contact;
use app\clientsBot\helpers\MenuHelper;
use app\toolkit\components\validators\TextValidator;


class NameCommand extends \app\bot\models\Command
{
    public function run(): void
    {
        $enteredText = trim($this->getBot()->getIncomeMessage()->getText());

        if (empty($enteredText) || $enteredText == $this->getBot()->getMenu()['name']) {
            $this->start();
            return;
        }

        $enteredText = preg_replace('/[^a-zA-ZА-Яа-я0-9-\s$]/u', '', $enteredText);

        if ((new TextValidator)->isValid($enteredText) === false) {
            $this->error($enteredText);
            return;
        }

        $this->end($enteredText);
    }


    private function start(): void
    {
        $sendPhoneButton = [
            'text' => $this->getBot()->getIncomeMessage()->getSenderFullName(),
        ];

        $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(
            [[$sendPhoneButton]],
            true,
            true,
            true
        );

        $message = $this
            ->getBot()
            ->getNewMessage()
            ->setMessageView('name/start')
            ->setKeyboardMarkup($keyboard);

        $this->getBot()->sendMessage($message);
    }


    private function error(string $name): void
    {
        $this->getBot()->sendMessage(
            $this->getBot()->getNewMessage()->setMessageView('name/error')->setAttributes([
                'name' => $name,
            ])
        );
    }


    private function end(string $name): void
    {
        Contact::repository()->update(
            ['name' => $name, 'command' => ''],
            ['id' => $this->getBot()->getUserId()]
        );

        $message = $this
            ->getBot()
            ->getNewMessage()
            ->setMessageView('thanks')
            ->setAttributes(['name' => $name])
            ->setKeyboardMarkup(MenuHelper::getKeyboardMarkup($this->getBot()->getMenu()));

        $this->getBot()->sendMessage($message);
    }
}
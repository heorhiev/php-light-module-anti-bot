<?php

namespace app\clientsBot\commands;

use app\clientsBot\entities\Contact;
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
        $this->getBot()->sendMessage(
            $this->getBot()->getNewMessage()->setMessageView('name/start')
        );
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
            ['name' => $name],
            ['id' => $this->getBot()->getUserId()]
        );

        $this->getBot()->sendMessage(
            $this->getBot()->getNewMessage()->setMessageView('thanks')->setAttributes([
                'name' => $name,
            ])
        );
    }
}
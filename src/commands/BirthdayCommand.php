<?php

namespace app\supportBot\commands;

use app\supportBot\entities\Contact;
use app\toolkit\components\validators\TextValidator;


class BirthdayCommand extends \app\bot\models\Command
{
    public function run(): void
    {
        $enteredText = trim($this->getBot()->getIncomeMessage()->getText());

        if (empty($enteredText)) {
            $this->start();
            return;
        }

        $enteredText = preg_replace('/[^0-9.\s$]/u', '', $enteredText);

        if ((new TextValidator)->isValid($enteredText) === false) {
            $this->error($enteredText);
            return;
        }

        $this->end($enteredText);
    }


    private function start(): void
    {
        $this->getBot()->sendMessage(
            $this->getBot()->getNewMessage()->setMessageView('birthday/start')
        );
    }


    private function error(string $birthday): void
    {
        $this->getBot()->sendMessage(
            $this->getBot()->getNewMessage()->setMessageView('birthday/error')->setAttributes([
                'birthday' => $birthday,
            ])
        );
    }


    private function end(string $birthday): void
    {
        Contact::repository()->update(
            ['birthday' => $birthday],
            ['id' => $this->getBot()->getUserId()]
        );

        $this->getBot()->sendMessage(
            $this->getBot()->getNewMessage()->setMessageView('thanks')->setAttributes([
                'birthday' => $birthday,
            ])
        );
    }
}
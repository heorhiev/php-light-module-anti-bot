<?php

namespace app\supportBot\commands;

use app\supportBot\entities\Contact;
use app\toolkit\components\validators\PhoneValidator;


class phoneCommand extends \app\bot\models\Command
{
    public function run(): void
    {
        if ($this->getSendedContact()) {
            $enteredText = $this->getSendedContact()->getPhoneNumber();
        } else {
            $enteredText = trim($this->getBot()->getIncomeMessage()->getText());
        }

        if (empty($enteredText)) {
            $this->start();
            return;
        }

        if ((new PhoneValidator)->isValid($enteredText) === false) {
            $this->error($enteredText);
            return;
        }

        $this->end($enteredText);
    }


    private function start(): void
    {
        $this->getBot()->sendMessage(
            $this->getBot()->getNewMessage()->setMessageView('phone/start')
        );
    }


    private function error(string $phone): void
    {
        $this->getBot()->sendMessage(
            $this->getBot()->getNewMessage()->setMessageView('phone/error')->setAttributes([
                'phone' => $phone,
            ])
        );
    }


    private function end(string $phone): void
    {
        Contact::repository()->update(
            ['phone' => $phone],
            ['id' => $this->getBot()->getUserId()]
        );

        /** @var Contact $contact */
        $contact = Contact::repository()->findById($this->getUserId())->asEntityOne();

        $this->getBot()->sendMessage(
            $this->getBot()->getNewMessage()->setMessageView('thanks')->setAttributes([
                'name' => $contact->name,
            ])
        );
    }


    private function getSendedContact(): ?\TelegramBot\Api\Types\Contact
    {
        return $this->getBot()->getDataFromRequest()->getMessage()->getContact();
    }
}
<?php

namespace app\antiBot\commands;

use app\antiBot\entities\Contact;
use app\antiBot\helpers\MenuHelper;
use app\toolkit\components\validators\PhoneValidator;


class phoneCommand extends \light\tg\bot\models\Command
{
    public function run(): void
    {
        if ($this->getSendedContact()) {
            $enteredText = $this->getSendedContact()->getPhoneNumber();
        } else {
            $enteredText = trim($this->getBot()->getIncomeMessage()->getText());
        }

        if (empty($enteredText) || $enteredText == $this->getBot()->getMenu()['phone']) {
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
        $sendPhoneButton = [
            'text' => "Надіслати номер телефону",
            'request_contact' => true
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
            ->setMessageView('phone/start')
            ->setKeyboardMarkup($keyboard);

        $this->getBot()->sendMessage($message);
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
            ['phone' => $phone, 'command' => ''],
            ['id' => $this->getBot()->getUserId()]
        );

        /** @var Contact $contact */
        $contact = Contact::repository()->findById($this->getUserId())->asEntityOne();

        $message = $this
            ->getBot()
            ->getNewMessage()
            ->setMessageView('phone/thanks')
            ->setAttributes(['name' => $contact->name, 'phone' => $phone])
            ->setKeyboardMarkup(MenuHelper::getKeyboardMarkup($this->getBot()->getMenu()));

        $this->getBot()->sendMessage($message);
    }


    private function getSendedContact(): ?\TelegramBot\Api\Types\Contact
    {
        return $this->getBot()->getDataFromRequest()->getMessage()->getContact();
    }
}
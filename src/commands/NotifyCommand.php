<?php

namespace app\antiBot\commands;

use app\antiBot\entities\Contact;
use app\antiBot\constants\BotConst;
use app\toolkit\services\LoggerService;


class NotifyCommand extends \light\tg\bot\models\Command
{
    public function run(): void
    {
        $adminChatIds = $this->getBot()->getOptions()->data['notify']['admins'];
        $currentUserId = $this->getBot()->getIncomeMessage()->getChat()->getId();

        if (!in_array($currentUserId, $adminChatIds)) {
            return;
        }

        $contacts = Contact::repository()->select(['id'])->filter([
            'status' => BotConst::CONTACT_STATUS_ACTIVE,
        ])->asArrayAll();

        $notifyText = trim($this->getBot()->getIncomeMessage()->getParams());

        $message = $this->getBot()->getNewMessage()->setMessageView('notify')->setAttributes([
            'countRecipients' => count($contacts),
            'notifyText' => $notifyText,
        ]);

        $this->getBot()->sendMessage($message);

        $message = $this->getBot()->getNewMessage();
        $message->setMessageText($notifyText);


        foreach ($contacts as $contact) {
            $message->setRecipientId($contact['id']);

            try {
                $this->getBot()->sendMessage($message);
                $this->sendFiles($contact['id']);
            } catch (\Exception $exception) {
                LoggerService::error($exception);
            }
        }
    }


    private function sendFiles($chatId)
    {
        $message = $this->getBot()->getDataFromRequest()->getMessage();

        if ($message->getVideo()) {
            $fileId = $message->getVideo()->getFileId();
            $this->getBot()->getBotApi()->sendVideo($chatId, $fileId);
        }

        if ($photos = $message->getPhoto()) {
            $fileId = end($photos)->getFileId();
            $this->getBot()->getBotApi()->sendPhoto($chatId, $fileId);
        }

        if ($message->getDocument()) {
            $fileId = $message->getDocument()->getFileId();
            $this->getBot()->getBotApi()->sendDocument($chatId, $fileId);
        }

        if ($message->getVoice()) {
            $fileId = $message->getVoice()->getFileId();
            $this->getBot()->getVoice()->sendVoice($chatId, $fileId);
        }
    }
}
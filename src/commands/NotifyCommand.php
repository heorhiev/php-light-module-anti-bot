<?php

namespace app\supportBot\commands;

use app\bot\models\Message;
use app\supportBot\utils\Forum;
use app\supportBot\entities\Contact;
use app\supportBot\constants\SupportBotConst;
use app\toolkit\services\LoggerService;


class NotifyCommand extends \app\bot\models\Command
{
    public function run(): void
    {
//        $files = $this->getBot()->getIncomeMessage()->getFiles();
//
//        file_put_contents('/var/www/keycrm/base/api_html/vipcall/runtime/logs/test.txt', print_r($files, 1));
//
//        $this->getBot()->getBotApi()->sendAudio(
//            $this->getBot()->getIncomeMessage()->getSenderId(),
//            $call['url']
//        );

        $contacts = Contact::repository()->select(['id'])->filter(['status' => SupportBotConst::CONTACT_STATUS_ACTIVE])->asArrayAll();

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
            } catch (\Exception $exception) {
                LoggerService::error($exception);
            }
        }
    }
}
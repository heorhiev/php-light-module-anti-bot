<?php

namespace app\supportBot\commands;

use app\supportBot\entities\Contact;
use app\supportBot\utils\Forum;
use app\supportBot\constants\SupportBotConst;


class SupportCloseCommand extends \app\bot\models\Command
{
    public function run(): void
    {
        $contactId = Forum::getTopicContactId(
            $this->getBot()->getUserId(),
            $this->getBot()->getIncomeMessage()->getThreadId()
        );

        $contact = Contact::repository()->findById($contactId)->asEntityOne();

        if ($contact->command == SupportBotConst::CONTACT_COMMAND_SUPPORT) {
            $message = $this->getBot()->getNewMessage()->setRecipientId($contactId)->setMessageView('support_close');
            $this->getBot()->sendMessage($message);

            Contact::repository()->update(
                ['command' => null],
                ['id' => $contactId]
            );

            $adminMessage = $this->getBot()
                ->getNewMessage()
                ->setMessageThreadId($this->getBot()->getIncomeMessage()->getThreadId())
                ->setMessageView('admin/support_close');

            $this->getBot()->sendMessage($adminMessage);
        }
    }
}
<?php

namespace app\supportBot\commands;

use app\bot\models\Message;
use app\supportBot\constants\SupportBotConst;
use app\supportBot\entities\{Contact, ForumTopic};
use app\supportBot\utils\Forum;


class MessageCommand extends \app\bot\models\Command
{
    public function run(): void
    {
        $contact = Contact::repository()->findById($this->getBot()->getUserId())->asEntityOne();

        if ($contact->command == SupportBotConst::CONTACT_COMMAND_SUPPORT) {
            // send user message to forum topic
            $forumTopicId = Forum::getContactTopicId($this->getBot());

            $message = new Message($this->getBot()->getOptions());
            $message->setMessageText($this->getBot()->getIncomeMessage()->getText());
            $message->setMessageThreadId($forumTopicId);

            Forum::sendMessage($this->getBot(), $message);

            return;
        }

        if ($this->getBot()->getIncomeMessage()->getThreadId() && !$this->getBot()->getIncomeMessage()->getFrom()->isBot()) {
            // send topic forum message to user
            $contactId = Forum::getTopicContactId(
                $this->getBot()->getUserId(),
                $this->getBot()->getIncomeMessage()->getThreadId()
            );

            $message = $this->getBot()->getNewMessage()->setRecipientId($contactId)->setMessageText(
                $this->getBot()->getIncomeMessage()->getText()
            );

            $this->getBot()->sendMessage($message);
        }
    }
}
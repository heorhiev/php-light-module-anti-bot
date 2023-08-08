<?php

namespace app\supportBot\commands;

use app\supportBot\constants\SupportBotConst;
use app\supportBot\entities\Contact;
use app\supportBot\utils\Forum;
use app\bot\models\Message;


class SupportCommand extends \app\bot\models\Command
{
    public function run(): void
    {
        $message = $this->getBot()->getNewMessage()->setMessageView('support');
        $this->getBot()->sendMessage($message);

        $adminMessage = $this->getBot()->getNewMessage();
        $adminMessage->setMessageView('admin/support');

        $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
            [[['text' => 'Завершити', 'callback_data' => '/support_close']]]
        );

        $adminMessage->setKeyboardMarkup($keyboard);

        $forumTopicId = Forum::getContactTopicId($this->getBot());

        if ($forumTopicId) {
            try {
                $adminMessage->setMessageThreadId($forumTopicId);
                Forum::sendMessage($this->getBot(), $adminMessage);
            } catch (\Exception $exception) {
                Forum::deleteTopic($forumTopicId);
                $forumTopicId = null;
            }   
        }

        if (!$forumTopicId) {
            $forumTopicId = Forum::createTopic($this->getBot());
            $adminMessage->setMessageThreadId($forumTopicId);
            Forum::sendMessage($this->getBot(), $adminMessage);
        }

        Contact::repository()->update(
            ['command' => SupportBotConst::CONTACT_COMMAND_SUPPORT],
            ['id' => $this->getBot()->getUserId()]
        );
    }
}
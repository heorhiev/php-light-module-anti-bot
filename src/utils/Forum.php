<?php

namespace app\supportBot\utils;

use app\bot\Bot;
use app\supportBot\entities\ForumTopic;
use app\bot\models\Message;
use phpDocumentor\Reflection\Types\True_;


class Forum
{
    public static function getContactTopicId(Bot $bot): ?int
    {
        $forumTopic = ForumTopic::repository()->filter([
            'forum_id' => $bot->getOptions()->data['support']['forum'],
            'contact_id' => $bot->getIncomeMessage()->getSenderId(),
        ])->asEntityOne();

        if ($forumTopic) {
            return $forumTopic->topic_id;
        }

        return null;
    }

    public static function getTopicContactId($forumId, $topicId): ?int
    {
        $forumTopic = ForumTopic::repository()->filter([
            'forum_id' => $forumId,
            'topic_id' => $topicId,
        ])->asEntityOne();

        return $forumTopic ? $forumTopic->contact_id : null;
    }

    public static function createTopic(Bot $bot): int
    {
        $name = sprintf(
            '%s (id: %s)',
            $bot->getIncomeMessage()->getSenderFullName(),
            $bot->getIncomeMessage()->getSenderId() + 101
        );

        $isPremium = $bot->getIncomeMessage()->getFrom()->getIsPremium();

        $forumTopic = $bot->getBotApi()->createForumTopic(
            $bot->getOptions()->data['support']['forum'],
            $name,
            $bot->getOptions()->data['support']['priorityColors'][$isPremium ? 'high' : 'low']
        );

        ForumTopic::repository()->create([
            'contact_id' => $bot->getIncomeMessage()->getSenderId(),
            'forum_id' => $bot->getOptions()->data['support']['forum'],
            'topic_id' => $forumTopic->getMessageThreadId(),
        ]);

        return $forumTopic->getMessageThreadId();
    }


    public static function sendMessage(Bot $bot, Message $message)
    {
        $message->setRecipientId($bot->getOptions()->data['support']['forum']);
        $bot->sendMessage($message);
    }


    public static function deleteTopic($topicId)
    {
        return ForumTopic::repository()->delete(['topic_id' => $topicId]);
    }


    public static function getForumContacts($forumId)
    {
        return ForumTopic::repository()->filter(['forum_id' => $forumId])->asArrayAll();
    }
}
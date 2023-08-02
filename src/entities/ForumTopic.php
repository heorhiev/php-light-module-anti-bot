<?php

namespace app\supportBot\entities;

use app\toolkit\components\Entity;
use app\toolkit\components\repository\Repository;
use app\supportBot\repository\ForumTopicRepository;


class ForumTopic extends Entity
{
    public $id;
    public $forum_id;
    public $topic_id;
    public $contact_id;

    
    public static function fields(): array
    {
        return [
            'integer' => ['id', 'topic_id', 'contact_id'],
            'string' => ['forum_id'],
        ];
    }


    public static function repository(): Repository
    {
        return new ForumTopicRepository(self::class);
    }
}
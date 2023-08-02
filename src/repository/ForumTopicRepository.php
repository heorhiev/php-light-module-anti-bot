<?php

namespace app\supportBot\repository;

use app\toolkit\components\repository\Repository;


class ForumTopicRepository extends Repository
{
    public static function tableName(): string
    {
        return 'support_bot_forum_topic';
    }
}
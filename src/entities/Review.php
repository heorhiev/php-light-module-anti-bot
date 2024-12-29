<?php

namespace light\module\antiBot\entities;

use light\orm\Entity;
use light\orm\repository\Repository;
use light\module\antiBot\repository\ReviewsRepository;


class Review extends Entity
{
    public $id;
    public $sender_id;
    public $recipient_id;
    public $text;
    public $created;



    public static function fields(): array
    {
        return [
            'integer' => ['id', 'sender_id', 'recipient_id'],
            'string' => ['text', 'created'],
        ];
    }


    public static function repository(): Repository
    {
        return new ReviewsRepository(self::class);
    }
}
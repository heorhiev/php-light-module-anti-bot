<?php

namespace light\module\antiBot\entities;

use light\orm\Entity;
use light\orm\repository\Repository;
use light\module\antiBot\repository\UserRequestsRepository;


class UserRequest extends Entity
{
    public $request_id;
    public $user_id;
    public $command;
    public $created;



    public static function fields(): array
    {
        return [
            'integer' => ['request_id', 'user_id'],
            'string' => ['command', 'created'],
        ];
    }


    public static function repository(): UserRequestsRepository
    {
        return new UserRequestsRepository(self::class);
    }
}
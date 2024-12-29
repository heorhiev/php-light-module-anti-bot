<?php

namespace light\module\antiBot\entities;

use light\orm\Entity;
use light\orm\repository\Repository;
use light\module\antiBot\repository\UsersRepository;


class User extends Entity
{
    public $id;
    public $command;
    public $command_data;
    public $status;
    public $created;



    public static function fields(): array
    {
        return [
            'integer' => ['id', 'status'],
            'string' => ['command', 'command_data', 'created'],
        ];
    }


    public static function repository(): Repository
    {
        return new UsersRepository(self::class);
    }
}
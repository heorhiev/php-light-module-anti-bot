<?php

namespace app\antiBot\entities;

use app\toolkit\components\Entity;
use app\toolkit\components\repository\Repository;
use app\antiBot\repository\ContactsRepository;


class Contact extends Entity
{
    public $id;
    public $name;
    public $command;
    public $phone;
    public $birthday;
    public $status;
    public $created;



    public static function fields(): array
    {
        return [
            'integer' => ['id', 'status'],
            'string' => ['name', 'phone', 'birthday', 'command', 'created'],
        ];
    }


    public static function repository(): Repository
    {
        return new ContactsRepository(self::class);
    }
}
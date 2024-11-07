<?php

namespace app\antiBot\repository;

use app\toolkit\components\repository\Repository;


class ContactsRepository extends Repository
{
    public static function tableName(): string
    {
        return 'clients_bot_contact';
    }
}
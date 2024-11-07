<?php

namespace app\antiBot\repository;

use light\orm\repository\Repository;


class ContactsRepository extends Repository
{
    public static function tableName(): string
    {
        return 'clients_bot_contact';
    }
}
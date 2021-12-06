<?php


namespace BotConstructor\core;


use BotConstructor\ORM\DB;

class MainRepository extends DB
{
    const TABLE_NAME = '';

    public function getData($userId) {
        return $this->q1("SELECT * FROM " . static::TABLE_NAME . " WHERE id = ?", [$userId]);
    }

    public function updateData($userId, $userData) {
        return $this->quArr(static::TABLE_NAME, $userData, $userId);
    }

    public function addData($userData) {
        return $this->qiArr(static::TABLE_NAME, $userData);
    }

}
<?php

namespace App\core;

class Model
{
    protected static function db()
    {
        return Database::connect();
    }
}
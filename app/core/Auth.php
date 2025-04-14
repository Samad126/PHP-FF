<?php

namespace App\core;

use App\models\User;

class Auth
{
    public static function check()
    {
        Session::start();
        return Session::get('user_id') !== null;
    }

    public static function user()
    {
        $userId = Session::get('user_id');
        return $userId ? User::find($userId) : null;
    }

    public static function login($user)
    {
        Session::start();
        Session::set('user_id', $user['id']);
    }

    public static function logout()
    {
        Session::destroy();
    }
}
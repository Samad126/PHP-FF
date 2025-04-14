<?php

namespace App\models;

use App\core\Model;

class User extends Model
{
    public static function attempt($email, $password)
    {
        $stmt = self::db()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user && password_verify($password, $user['password']) ? $user : null;
    }

    public static function create($data)
    {
        $stmt = self::db()->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$data['name'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT)]);
    }

    public static function find($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}

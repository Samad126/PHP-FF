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
        
        // Note: column name changed from password to password_hash
        return $user && password_verify($password, $user['password_hash']) ? $user : null;
    }

    public static function create($data)
    {
        // Validate password confirmation
        if ($data['password'] !== $data['password_confirm']) {
            return false;
        }

        $stmt = self::db()->prepare(
            "INSERT INTO users (email, password_hash, fullname) 
             VALUES (?, ?, ?)"
        );
        
        return $stmt->execute([
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['name'] // This will be stored as fullname in the database
        ]);
    }

    public static function find($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}

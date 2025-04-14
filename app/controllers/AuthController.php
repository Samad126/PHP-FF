<?php

namespace App\controllers;

use App\core\Controller;
use App\models\User;
use App\core\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = User::attempt($_POST['email'], $_POST['password']);
            if ($user) {
                Auth::login($user);
                header('Location: /');
                exit;
            }
            echo "Invalid credentials";
        }
        $this->view('login');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            User::create($_POST);
            header('Location: /login');
            exit;
        }
        $this->view('register');
    }

    public function logout()
    {
        Auth::logout();
        header('Location: /');
    }
}

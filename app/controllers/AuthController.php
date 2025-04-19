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
                
                // Check if there's a redirect URL
                $redirect = $_GET['redirect'] ?? '/';
                header('Location: ' . $redirect);
                exit;
            }
            
            $_SESSION['error'] = 'Invalid credentials';
            $this->view('login', ['error' => 'Invalid credentials']);
            return;
        }
        $this->view('login');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate password confirmation
            if ($_POST['password'] !== $_POST['password_confirm']) {
                $_SESSION['error'] = 'Passwords do not match';
                $this->view('register', ['error' => 'Passwords do not match']);
                return;
            }

            // Create user
            $success = User::create($_POST);
            
            if ($success) {
                $_SESSION['success'] = 'Registration successful. Please login.';
                header('Location: /login');
                exit;
            }
            
            $_SESSION['error'] = 'Registration failed';
            $this->view('register', ['error' => 'Registration failed']);
            return;
        }
        $this->view('register');
    }

    public function logout()
    {
        Auth::logout();
        header('Location: /');
        exit;
    }
}

<?php

namespace App\core;

class Controller
{
    public function view($view, $data = [], $title = null)
    {
        extract($data);
        $viewPath = "../app/views/{$view}.php";
        require_once "../app/views/layout.php";
    }
}

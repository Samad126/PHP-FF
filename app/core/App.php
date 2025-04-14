<?php

namespace App\core;

class App
{
    protected $controller = "HomeController";
    protected $method = "index";
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (file_exists("../app/controllers/" . ucfirst($url[0]) . "Controller.php")) {
            $this->controller = ucfirst($url[0]) . "Controller";
            unset($url[0]);
        }

        $controllerClass = "App\\controllers\\" . $this->controller;
        $this->controller = new $controllerClass;

        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl()
    {
        if (isset($_SERVER['PATH_INFO'])) {
            return explode("/", trim($_SERVER['PATH_INFO'], "/"));
        }
        return ['home'];
    }
}

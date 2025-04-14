<?php

namespace App\core;

class Router
{
    private static $routes = [];
    
    public static function get($path, $callback)
    {
        self::$routes['GET'][$path] = $callback;
    }
    
    public static function post($path, $callback)
    {
        self::$routes['POST'][$path] = $callback;
    }
    
    public static function resolve()
    {
        $path = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];
        
        $callback = self::$routes[$method][$path] ?? false;
        
        if (!$callback) {
            http_response_code(404);
            return "Not found";
        }
        
        if (is_array($callback)) {
            $controller = new $callback[0]();
            $callback[0] = $controller;
        }
        
        return call_user_func($callback);
    }
}
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
    
    private static function matchRoute($requestPath)
    {
        foreach (self::$routes[$_SERVER['REQUEST_METHOD']] as $routePath => $callback) {
            // Convert route parameters like {id} to regex pattern
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $routePath);
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = '/^' . $pattern . '$/';

            if (preg_match($pattern, $requestPath, $matches)) {
                // Remove the full match from the matches array
                array_shift($matches);
                return ['callback' => $callback, 'params' => $matches];
            }
        }
        return false;
    }
    
    public static function resolve()
    {
        $path = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];
        
        $route = self::matchRoute($path);
        
        if (!$route) {
            http_response_code(404);
            return "Not found";
        }
        
        $callback = $route['callback'];
        $params = $route['params'];
        
        if (is_array($callback)) {
            $controller = new $callback[0]();
            return call_user_func_array([$controller, $callback[1]], $params);
        }
        
        return call_user_func_array($callback, $params);
    }
}

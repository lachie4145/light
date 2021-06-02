<?php


class Router
{
    private static $routes = [];
    private static $subDirectory = null;
    private static $notFoundMessage = "<h1>404 Not Found</h1>";

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function addDirectory($dir)
    {
        self::$subDirectory = "/".$dir;
    }

    private static function processRouteString($string)
    {
        if(preg_match("/({.*?})/", $string)) {
            $string = preg_replace("/({.*?})/", "([a-zA-Z0-9]+)", $string);
        }
        return $string;
    }

    public static function Get($route, $callback)
    {
        array_push(self::$routes, [
            'route' => self::$subDirectory.self::processRouteString($route),
            'method' => 'GET',
            'callback' => $callback
        ]);
    }

    public static function Post($route, $callback)
    {
        array_push(self::$routes, [
            'route' => self::$subDirectory.$route,
            'method' => 'POST',
            'callback' => $callback
        ]);
    }

    public static function Run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $current = $_SERVER['REQUEST_URI'];
        $args = [];

        foreach (self::$routes as $route) {
            if(preg_match("/(".str_replace('/', '\/', $route['route'])."$)/", $current)) {
                if ($route['method'] === $method) {
                    $args = self::extractArgs($route['route'], $current);
                    call_user_func_array($route['callback'], $args);
                } else {
                    die(self::$notFoundMessage);
                }
            }
        }
    }

    private static function extractArgs($pattern, $url)
    {
        $output = [];
        preg_match("/".str_replace('/', '\/', $pattern)."/", $url, $output);
        unset($output[0]);
        return $output;
    }
}
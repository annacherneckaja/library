<?php

namespace vendor\core;
class Router
{
    protected static array $routes = [];
    protected static array $route = [];

    public static function add($regexp, $route)
    {
        self::$routes[$regexp] = $route;
    }

    public static function matchRoute($url)
    {
        $url = parse_url($url, PHP_URL_PATH);
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("~$pattern~i", $url, $matches)) {
                foreach ($matches as $k => $v) {
                    if ($k === 'controller') {
                        $route[$k] = self::upperCamelCase($v);
                    } elseif (is_string($k))
                        $route[$k] = self::lowerCamelCase($v);
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }
                self::$route = $route;
                return true;
            }
        }

        return false;
    }

    /**
     * перенаправляем url по корректному маршруту
     * @param $url - входящий url
     * @throws \Exception сли метод или контроллер не найдены
     */
    public static function dispatch($url)
    {
        if (self::matchRoute($url)) {
            $controller_class = 'app\controllers\\' . self::$route['controller']. 'Controller';
            if (class_exists($controller_class)) {
                $controller_obj = new $controller_class(self::$route);
                $action = self::$route['action'] . 'Action';
                if (method_exists($controller_obj, $action)) {
                    $controller_obj->$action();
                } else {
                    throw new \Exception("Метод " . $action . " не найден");
                }
            } else {
                throw new \Exception("Контроллер " . $controller_class . " не найден");
            }
        } else {
            throw new \Exception("Страница не найдена", 404);
        }
    }

    protected static function upperCamelCase($name)
    {
        $name = ucwords(str_replace('-', ' ', $name));
        return str_replace(' ', '', $name);
    }

    protected static function lowerCamelCase($name)
    {
        return lcfirst(self::upperCamelCase($name));
    }
}
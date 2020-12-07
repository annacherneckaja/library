<?php
use vendor\core\Router;
use vendor\core\ErrorHandler;

$url = trim($_SERVER['REQUEST_URI'], '/');
parse_str($_SERVER['QUERY_STRING'], $query);

require '../config/constants.php';
require '../vendor/libs/functions.php';

spl_autoload_register(function ($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) require_once $file;
});

new ErrorHandler();
require '../routes/routes.php';

Router::dispatch($url);
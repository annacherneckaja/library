<?php


namespace vendor\core;

class ErrorHandler
{
    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }
        set_error_handler([$this, 'errorHandler'], E_ALL);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        $this->writeLog($errstr, $errfile, $errline);
        $this->displayError($errno, $errstr, $errfile, $errline);
        return true;
    }

    public function fatalErrorHandler()
    {
        $error = error_get_last();
        if (is_array($error) &&
            in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            ob_end_clean();
            $this->writeLog($error['message'], $error['file'], $error['line']);
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }

    protected function writeLog($message, $file, $line, $code = 500)
    {
        $date = date('Y-m-d h:i:s');
        error_log("[" . $date . "] Текст помилки {$message}; Файл {$file}; Строка {$line}\n",
            3, ROOT . '/errors.log.txt');
    }

    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500)
    {
        http_response_code($response);
        if (DEBUG) {
            require APP . '/views/Errors/dev.php';
        } else {
            if (($response == 404)) {
                require APP . '/views/Errors/404.html';
            } else {
                require APP . '/views/Errors/prod.php';
            }
        }
    }
}
<?php


namespace vendor\core;

//use PDO;
use PDO;
use PDOException;

class Db
{
    protected $pdo;
    protected static $instance;

    protected function __construct()
    {
        $db = require ROOT . '/config/config_db.php';
        try {
            $this->pdo = new PDO($db['dsn'], $db['user'], $db['pass']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     *  Метод-обертка для PDOStatement::execute()
     */
    public function execute($query, $params = array())
    {
        // подготавливаем запрос к выполнению
        $stmt = $this->pdo->prepare($query);
        // выполняем запрос
        if (empty($params)) {
            $stmt->execute();
        } else {
            $stmt->execute($params);
        }
    }

    /**
     * Метод-обертка для PDOStatement::fetchAll()
     */
    public function fetchAll($query, $params = array())
    {
        $stmt = $this->pdo->prepare($query);
        // выполняем запрос
        if (empty($params)) {
            $stmt->execute();
        } else {
                $stmt->execute($params);
        }
        // получаем результат
        // возвращаем результаты запроса
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Метод-обертка для PDOStatement::fetch()
     */
    public function fetch($query, $params = array())
    {
        // подготавливаем запрос к выполнению
        $stmt = $this->pdo->prepare($query);
        // выполняем запрос
        if (empty($params)) {
            $stmt->execute();
        } else {
            $stmt->execute($params);
        }
        // возвращаем результат запроса
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function count($query, $params = array())
    {
        // подготавливаем запрос к выполнению
        $stmt = $this->pdo->prepare($query);
        // выполняем запрос
        if (empty($params)) {
            $stmt->execute();
        } else {
            $stmt->execute($params);
        }
        // возвращаем результат запроса
        return $stmt->fetchColumn();
    }

    public function fetchOne($query, $params = array())
    {
        // подготавливаем запрос к выполнению
        $stmt = $this->pdo->prepare($query);
        // выполняем запрос
        if (empty($params)) {
            $stmt->execute();
        } else {
            $stmt->execute($params);
        }
        // получаем результат
        $result = $stmt->fetch(PDO::FETCH_NUM);
        // возвращаем результат запроса
        if (false === $result) {
            return false;
        }
        return $result[0];
    }

    public function lastInsertId()
    {
        return (int)$this->pdo->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    public function commit()
    {
        return $this->pdo->commit();
    }

    public function rollBack()
    {
        return $this->pdo->rollBack();
    }

}
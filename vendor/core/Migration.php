<?php


namespace vendor\core;

/**
 * Класс для изменения состояния базы данных и учета этих изменений
 */
class Migration
{

    /**
     * Хост базы данных
     */
    private $host;
    /**
     * Имя базы данных
     */
    private $name;
    /**
     * Пользователь базы данных
     */
    private $user;
    /**
     * Пароль базы данных
     */
    private $pass;
    /**
     * Имя таблицы БД для учета миграций
     */
    private $stateTable;
    /**
     * Для хранения экземпляра класса для работы с базой данных
     */
    private Db $database;


    public function __construct()
    {
        $db = require ROOT . '/config/config_db.php';

        $this->host = $db['host'];
        $this->name = $db['dbname'];
        $this->user = $db['user'];
        $this->pass = $db['pass'];
        $this->stateTable = 'versions';

        $this->database = Db::instance();
    }

    /**
     * Функция несколько раз изменяет состояние базы данных, выполняет запросы
     * из тех SQL-файлов, которые еще не выполнялись ранее
     */
    public function migrate()
    {

        // получаем список файлов для миграции
        $files = $this->getNewFiles();
        // нечего делать, база данных в актуальном состоянии
        if (empty($files)) {
            echo 'Your database in latest state';
            return;
        }

        echo 'Start database migration', PHP_EOL;
        // выполняем SQL-запросы из каждого файла
        foreach ($files as $file) {
            $this->execute($file);
            echo 'Execute file ', basename($file), PHP_EOL;
        }
        echo 'Database migration complete';
    }

    /**
     * Функция возвращает массив старых файлов миграций, т.е.
     * тех, которые уже были применены к БД
     */
    private function getOldFiles()
    {
        $oldFiles = array();
        if ($this->isEmpty()) {
            return $oldFiles;
        }

        $query = 'SELECT `name` FROM `' . $this->stateTable . '` WHERE 1';
        $rows = $this->database->fetchAll($query);
        foreach ($rows as $row) {
            array_push($oldFiles, '../sql/' . $row['name']);
        }
        return $oldFiles;
    }

    /**
     * Функция возвращает массив новых файлов миграций, т.е.
     * тех, которые еще не были применены к БД
     */
    private function getNewFiles()
    {
        // получаем список всех sql-файлов
        $allFiles = glob('C:/MAMP/htdocs/library/sql/' . '*.sql');
        // получаем список старых файлов
        $oldFiles = $this->getOldFiles();
        return array_diff($allFiles, $oldFiles);
    }

    /**
     * Функция выполняет запросы из sql-файла
     */
    private function execute($file)
    {
        // Формируем команду выполнения mysql-запроса из внешнего файла
        $command = sprintf('C:/MAMP/bin/mysql/bin/mysql -u%s -p%s -h %s -D %s < %s', $this->user, $this->pass, $this->host, $this->name, $file);
        shell_exec($command);

        // добавляем запись в таблицу учета миграций, отмечая тот факт,
        // что состояние базы данных изменилось
        $query = 'INSERT INTO `' . $this->stateTable . '` (`name`) VALUES ("' . basename($file) . '")';
        $this->database->execute($query);
    }

    /**
     * Функция проверяет, есть ли в базе данных таблицы
     */
    private function isEmpty()
    {
        $query = sprintf('show tables from `%s` like "%s"', $this->name, $this->stateTable);
        $rows = $this->database->fetchAll($query);
        return empty($rows);
    }

}
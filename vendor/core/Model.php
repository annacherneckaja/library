<?php


namespace vendor\core;


abstract class Model
{
    protected Db $pdo;
    protected Migration $migration;
    public array $params = [];


    public function __construct($params)
    {
        $this->params = $params;
        $this->filter();
        $this->pdo = Db::instance();
        $this->migration = new Migration();
    }

    protected function filter(){
        foreach ($this->params as $k => $v) {
            if (is_string($this->params[$k]))
                $this->params[$k] = filter_var(trim($v), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (is_array($this->params[$k])) {
                for ($i =0 ; $i<count($this->params[$k]); $i++) {
                    $this->params[$k][$i] = filter_var(trim($this->params[$k][$i]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                }
            }
        }    }
}
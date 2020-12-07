<?php


namespace vendor\core;


abstract class Controller
{
    public array $route = [];
    public Model $model;
    public View $view;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($this->route);
    }

}
<?php


namespace vendor\core;


class View
{
    public array $route = [];
    public string $layout;
    public static array $meta = ['title' => '', 'description' => '', 'keywords' => ''];

    public function __construct($route)
    {
        $this->route = $route;
    }

    public function getView($layout = '', $vars = [])
    {
        $this->layout = $layout ? $layout : LAYOUT;
        if (is_array($vars)) {
            extract($vars);
        }

        $file_view = APP . "/views/{$this->route['controller']}/{$this->route['action']}.php";
        $file_layout = APP . "/views/layouts/$this->layout.php";

        if (is_file($file_layout)) {
            require $file_layout;
        } else {
            echo "<p>не найден шаблон <b>$file_layout</b></p>";
        }
    }

    public function getMeta()
    {
        echo '<title>' . self::$meta['title'] . '</title>
                <meta name="description" content="'.self::$meta['description'].'">
                <meta name="keywords" content="'.self::$meta['keywords'].'">';
    }


    public function setMeta($title, $description, $keywords)
    {
        self::$meta['title'] = $title;
        self::$meta['description'] = $description;
        self::$meta['keywords'] = $keywords;
    }
}
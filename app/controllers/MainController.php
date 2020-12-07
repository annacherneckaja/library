<?php

namespace app\controllers;

use app\models\Books;
use vendor\core\Controller;


class MainController extends Controller
{
    /**
     * main page
     */

    public function indexAction()
    {
        $this->model = new Books([]);
        $data = $this->model->getBooks();
        $this->view->setMeta('library', 'my first library', 'books');
        $this->view->getView('default', $data);
    }

    /**
     * parameters - custom request
     * model - search by request
     */
    public function searchAction()
    {
        $this->model = new Books(['%' . $this->route['alias'] . '%']);
        $data = $this->model->searchByString();
        $this->view->getView('default', $data);
    }

    /**
     * put the book number in the parameters
     * call the model that will return the book
     */
    public function viewAction()
    {
        $this->model = new Books([$this->route['alias']]);
        $book = $this->model->getBook();
        $this->view->getView('default', $book);
    }

    /**
     * parameters - the number of the book you selected
     * model - incrementing the number of clicks
     */
    public function clickAction()
    {
        $this->model = new Books($_POST);
        $this->model->clickBook();
    }
}
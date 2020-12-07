<?php


namespace app\controllers;

use app\models\Books;
use vendor\core\Controller;

class AdminController extends Controller
{
    /**
     * main page
     */
    public function indexAction()
    {

        $this->model = new Books([]);
        $books = $this->model->getBooks();
        $this->view->getView('admin', $books);
    }

    /**
     * input parameters - data about the book and authors
     * add a book, add authors and add a book-authors relationship
     */
    public function addBookAction()
    {
        $this->model = new Books($_POST);
        $this->model->addBook();
        if ($_POST['author'] != 0) {
            $this->model->addAuthors();
        }
        $this->model->addBookAuthorsLinks();

        header("Location: ../admin");

    }

    /**
     * put the book number in the parameters
     * call the model that will return the book
     */
    public function getBookAction()
    {
        $this->model = new Books([$this->route['alias']]);
        $book = $this->model->getBook();
        $this->view->getView('default', $book);

    }

    /**
     * parameters - updated data
     * call update model in the table
     */
    public function editBookAction()
    {
        $this->model = new Books($_POST);
        $this->model->editBook();
        header("Location: ../admin");
    }

    /**
     * parameters - custom request
     * model - search by request
     */
    public function searchAction()
    {
        $this->model = new Books(['%' . $this->route['alias'] . '%']);
        $books = $this->model->searchByString();
        $this->view->getView('admin', $books);
    }

    /**
     * parameters - the number of the book to be deleted
     * model - delete the given book
     */
    public function deleteBookAction()
    {
        $this->model = new Books([$this->route['alias']]);
        $this->model->deleteBook();
        header("Location: ../admin");
    }
}
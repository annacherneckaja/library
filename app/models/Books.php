<?php


namespace app\models;

use Exception;
use vendor\core\Model;
use vendor\core\Pagination;

class Books extends Model
{
    // displays data about all books and authors, authors separated by commas
    public function getBooks()
    {
        // add pagination
        $pagination = $this->getPagination();

        $query = "SELECT books.*, GROUP_CONCAT(DISTINCT authors.name SEPARATOR ', ') AS author
                FROM books
                LEFT JOIN book_authors ON books.book_id=book_authors.book_id 
                LEFT JOIN authors ON book_authors.author_id=authors.author_id
                WHERE books.deleted LIKE '0000-00-00 00:00:00' OR books.deleted is null 
                GROUP BY books.book_id
                LIMIT {$pagination->getStart()}, $pagination->perpage";

        // select all data from the table upon query
        $data['books'] = $this->pdo->fetchAll($query, $this->params);
        $data['pagination'] = $pagination;
        return $data;
    }

    // displays book and authors by book id
    public function getBook()
    {
        $query = "UPDATE books
                    SET view_count=view_count+1
                    WHERE book_id LIKE ?";
        $this->pdo->execute($query, $this->params);

        $query = "SELECT books.*, GROUP_CONCAT(DISTINCT authors.name SEPARATOR ', ') AS author
                FROM books
                LEFT JOIN book_authors ON books.book_id=book_authors.book_id 
                LEFT JOIN authors ON book_authors.author_id=authors.author_id
                GROUP BY books.book_id 
                Having books.book_id LIKE ? 
                AND (books.deleted LIKE '0000-00-00 00:00:00' OR books.deleted is null)";
        // select one data from the table upon query
        return $this->pdo->fetch($query, $this->params);
    }

    // select all books in which there is a match by author, title or year
    public function searchByString()
    {
        // add pagination
        $pagination = $this->getPagination();
        $query = "SELECT books.*, GROUP_CONCAT(DISTINCT authors.name SEPARATOR ', ') AS author
                FROM books
                LEFT JOIN book_authors ON books.book_id=book_authors.book_id 
                LEFT JOIN authors ON book_authors.author_id=authors.author_id
                GROUP BY books.book_id 
                Having concat(books.name, books.year, author) LIKE ? 
                AND (books.deleted LIKE '0000-00-00 00:00:00' OR books.deleted is null)  
                LIMIT {$pagination->getStart()}, $pagination->perpage";
        // select all data from the table upon query
        $data['books'] = $this->pdo->fetchAll($query, $this->params);
        $data['pagination'] = $pagination;
        return $data;
    }

    // add new book
    public function addBook()
    {
       if(!is_numeric($this->params['pages'])){
           $this->params['pages'] = 0;
       }
       if(!is_numeric($this->params['year'])){
           $this->params['year'] = 0;
       }
       if(empty($this->params['image'])){
           $this->params['image'] = 'default.png';
       }
        $query = "INSERT INTO books
                (`name`, `pages`, `year`, `isbn`, `description`, `image`) 
                VALUES 
                (N'{$this->params['name']}', 
                 '{$this->params['pages']}', 
                 '{$this->params['year']}', 
                 N'{$this->params['isbn']}', 
                 N'{$this->params['description']}',
                 '{$this->params['image']}')";
        $this->migrate($query, "add_book");
    }

    // add authors if they are not yet in the table
    public function addAuthors()
    {
        $query = "";
        foreach ($this->params['author'] as $value) {
            if ($value != '') {
                $query .= "INSERT INTO authors (name)
            SELECT N'{$value}'
            FROM DUAL
            WHERE NOT EXISTS(
                SELECT 1
                FROM authors
                WHERE name = N'{$value}'
            )
            LIMIT 1;";
            }
        }
        // if the request is not empty, we migrate
        if (!empty($query))
            $this->migrate($query, "add_authors");
    }

    // accepts data for updating in parameters and update the table
    public function editBook()
    {
        if(!is_numeric($this->params['pages'])){
            $this->params['pages'] = 0;
        }
        if(!is_numeric($this->params['year'])){
            $this->params['year'] = 0;
        }
        if(empty($this->params['image'])){
            $this->params['image'] = 'default.png';
        }
        $query = "UPDATE books
                    SET name= N'{$this->params['name']}',
                        pages='{$this->params['pages']}', 
                        year='{$this->params['year']}', 
                        isbn=N'{$this->params['isbn']}', 
                        description=N'{$this->params['description']}',
                        image='{$this->params['image']}'
                    WHERE book_id = {$this->params['book_id']};\n
                    DELETE FROM book_authors
                    WHERE book_id = {$this->params['book_id']};\n";


        $this->migrate($query, 'edit_book');
        // add Authors and Book-Authors links
        $this->addAuthors();
        $this->addBookAuthorsLinks();
    }

    // add link book-author
    public function addBookAuthorsLinks()
    {
        // define book id
        $book_id = $this->pdo->fetchOne("SELECT book_id FROM books WHERE name LIKE ?", [$this->params['name']]);
        $query = "";
        foreach ($this->params['author'] as $value) {
            if ($value != '') {
                // define authors ids
                $author_id = $this->pdo->fetchOne("SELECT author_id FROM authors WHERE name LIKE ?", [$value]);
                $query .= "INSERT INTO book_authors
                            (book_id, author_id)
                            VALUES
                            ('{$book_id}', '{$author_id}');\n";
            }
        }
        if (!empty($query))
            $this->migrate($query, 'add_book_authors_links');
    }

    // put the current date in the column `deleted`, delete under a certain condition
    public function deleteBook()
    {
        $query = "UPDATE books
                    SET `deleted`= current_timestamp
                    WHERE book_id LIKE '{$this->params[0]}'";
        $this->migrate($query, 'delete_book');
    }

    // increment the click counter
    public function clickBook()
    {
        $query = "UPDATE books
                    SET click_count=click_count+1
                    WHERE book_id LIKE ?";
        $this->pdo->execute($query, [$this->params['id']]);
    }

    protected function migrate($query, $migration_description)
    {
        $file_name = SQL . '/' . date('Y-m-d-h-i-s-') . $migration_description . '.sql';
        if (!file_put_contents($file_name, $query)) {
            throw new Exception('не удалось создать файл' . $migration_description);
        }
        $this->migration->migrate();
    }

    // create an instance of the class Pagination
    protected function getPagination()
    {
        $query = "SELECT COUNT(DISTINCT books.book_id) 
                    FROM books
                    LEFT JOIN book_authors ON books.book_id=book_authors.book_id 
                    LEFT JOIN authors ON book_authors.author_id=authors.author_id
                    WHERE (books.deleted LIKE '0000-00-00 00:00:00' OR books.deleted is null)";
        if (isset($this->params[0])) {
            $query .= " AND concat(books.name, books.year, authors.name) LIKE '{$this->params[0]}'";
        }
        $page = isset($_GET['page'])? $_GET['page']: 1;
        $total = $this->pdo->count($query);
        $prepage = 6;
        return new Pagination($page, $prepage, $total);
    }
}
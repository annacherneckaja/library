-- delete books
DELETE books, book_authors
FROM books
         INNER JOIN book_authors ON books.book_id = book_authors.book_id
WHERE books.deleted < (NOW() - INTERVAL 1 DAY);
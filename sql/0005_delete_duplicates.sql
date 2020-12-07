DELETE t1
FROM books t1
INNER JOIN books t2
WHERE t1.book_id > t2.book_id
AND t1.name = t2.name;

DELETE t1
FROM authors t1
         INNER JOIN authors t2
WHERE t1.author_id > t2.author_id
  AND t1.name = t2.name;
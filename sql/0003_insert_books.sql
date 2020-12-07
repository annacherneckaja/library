-- insert books--
LOAD DATA LOCAL INFILE 'C:\\MAMP\\htdocs\\library\\public\\data\\books.csv'
    INTO TABLE library.books
    CHARACTER SET utf8mb4
    FIELDS TERMINATED BY ';'
    ENCLOSED BY '"'
    LINES TERMINATED BY '\r\n'
    IGNORE 1 LINES;
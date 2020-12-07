-- empty the table authors--
TRUNCATE TABLE authors;

-- load data

LOAD DATA LOCAL INFILE 'C:\\MAMP\\htdocs\\library\\public\\data\\authors.csv'
    INTO TABLE library.authors
    CHARACTER SET utf8mb4
    FIELDS TERMINATED BY ';'
    ENCLOSED BY '"'
    LINES TERMINATED BY '\r\n'
    IGNORE 1 LINES;
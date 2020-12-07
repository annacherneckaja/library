DROP table if exists `books`;

create table if not exists `books`
(
    `book_id`     int(11) unsigned not null auto_increment,
    `name`        varchar(255)     not null,
    `pages`       int(11) DEFAULT 0,
    `year`        int(11) DEFAULT 0,
    `isbn`        varchar(255),
    `description` text,
    `image`       varchar(255),
    `click_count` int(11) DEFAULT 0,
    `view_count`  int(11) DEFAULT 0,
    `deleted`     datetime,
    primary key (book_id)
)
    engine = innodb
    auto_increment = 1
    character set utf8mb4
    collate utf8mb4_general_ci;

DROP table if exists `versions`;

create table if not exists `versions`
(
    `id`      int(10) unsigned not null auto_increment,
    `name`    varchar(255)     not null,
    `created` timestamp default current_timestamp,
    primary key (id)
)
    engine = innodb
    auto_increment = 1
    character set utf8mb4
    collate utf8mb4_general_ci;

DROP table if exists `authors`;

create table `authors`
(
    `author_id` int(11) unsigned not null auto_increment,
    `name`      varchar(255)     not null,
    primary key (author_id)
)
    engine = innodb
    auto_increment = 1
    character set utf8mb4
    collate utf8mb4_general_ci;

DROP table if exists `book_authors`;

create table `book_authors`
(
    `id`        int(11) unsigned not null auto_increment,
    `author_id` int(11) unsigned not null,
    `book_id`   int(11) unsigned not null,
    primary key (id)
)
    engine = innodb
    auto_increment = 1
    character set utf8mb4
    collate utf8mb4_general_ci;
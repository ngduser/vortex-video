USE vigilant-video;

DROP TABLE UserAccounts;

CREATE TABLE UserAccounts (
    id INT UNSIGNED AUTO_INCREMENT,
    username VARCHAR(65) NOT NULL UNIQUE,
    password VARCHAR(60) NOT NULL,
    PRIMARY KEY(id)
);

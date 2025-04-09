DROP DATABASE IF EXISTS meetic;
CREATE DATABASE meetic;

USE meetic;

DROP TABLE IF EXISTS user_hobby;
DROP TABLE IF EXISTS user_genre;
DROP TABLE IF EXISTS user_log;
DROP TABLE IF EXISTS hobby;
DROP TABLE IF EXISTS genre;
DROP TABLE IF EXISTS activity_log;
DROP TABLE IF EXISTS user;

CREATE TABLE activity_log (
    id            INT                     NOT NULL AUTO_INCREMENT,
    name          VARCHAR(255)            NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE user (
    id             INT                     NOT NULL AUTO_INCREMENT,
    pseudo         VARCHAR(255)            NOT NULL UNIQUE,
    firstname      VARCHAR(255)            NOT NULL,
    lastname       VARCHAR(255)            NOT NULL,
    birthdate      DATE                    NOT NULL,
    city           VARCHAR(255)            NOT NULL,
    email          VARCHAR(255)            NOT NULL UNIQUE,
    password       VARCHAR(255)            NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE user_log (
    id_user         INT                   NOT NULL,
    id_log          INT                   NOT NULL,
    PRIMARY KEY (id_user, id_log),
    FOREIGN KEY (id_user) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (id_log) REFERENCES activity_log(id) ON DELETE CASCADE
);

CREATE TABLE hobby (
    id              INT                    NOT NULL AUTO_INCREMENT,
    name            VARCHAR(255)           NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE user_hobby (
    id_user         INT                   NOT NULL,
    id_hobby        INT                   NOT NULL,
    PRIMARY KEY (id_user, id_hobby),
    FOREIGN KEY (id_user) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (id_hobby) REFERENCES hobby(id) ON DELETE CASCADE
);

CREATE TABLE genre (
    id              INT                  NOT NULL AUTO_INCREMENT,
    name            VARCHAR(255)         NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE user_genre (
    id_user         INT                 NOT NULL,
    id_genre        INT                 NOT NULL,
    PRIMARY KEY (id_user, id_genre),
    FOREIGN KEY (id_user) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (id_genre) REFERENCES genre(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `match` (
    id_user INT NOT NULL,
    id_matched_user INT NOT NULL,
    PRIMARY KEY (id_user, id_matched_user),
    FOREIGN KEY (id_user) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (id_matched_user) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS message (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES user(id) ON DELETE CASCADE
);



INSERT INTO hobby (name)
VALUES  
    ('Musique'),
    ('Lecture'),
    ('Animaux'),
    ('Films/Series'),
    ('Sport'),
    ('Jeux vidéos'),
    ('Voyage'),
    ('Jardinage');

INSERT INTO genre (name)
VALUES  
    ('Man'),
    ('Woman'),
    ('Others');

INSERT INTO activity_log (name)
VALUES  
    ('Active'),
    ('Desactive');


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

INSERT INTO user (pseudo, firstname, lastname, birthdate, city, email, password)
VALUES  
    ('geek12', 'Randy', 'Poche', '1997-10-28', 'Clermont-Ferrand', 'randy.poche@gmail.com', 'brakata'),
    ('girly', 'Lucie', 'Wayne', '1998-11-18', 'Clermont-Ferrand', 'luciewayn12@gmail.com', 'jacko12'),
    ('gamer101', 'Clara', 'Dupont', '2000-08-15', 'Marseille', 'clara.dupont@gmail.com', 'gaming42'),
    ('chocoLover', 'David', 'Moreau', '1995-12-11', 'Bordeaux', 'david.moreau@gmail.com', 'chocoLover123'),
    ('wanderlust', 'Emma', 'Blanc', '1998-09-03', 'Nice', 'emma.blanc@gmail.com', 'travel77'),
    ('bookworm', 'Felix', 'Noir', '1994-01-25', 'Toulouse', 'felix.noir@gmail.com', 'readmore99'),
    ('artsy', 'Gabrielle', 'Roche', '1997-07-19', 'Strasbourg', 'gabrielle.roche@gmail.com', 'paintIt'),
    ('coderPro', 'Hugo', 'Fontaine', '1999-04-10', 'Nantes', 'hugo.fontaine@gmail.com', 'codeLife98'),
    ('natureGuy', 'Isabelle', 'Chevalier', '1993-10-20', 'Grenoble', 'isabelle.chevalier@gmail.com', 'natureWalks'),
    ('fitnessFan', 'Jack', 'Lambert', '1991-12-15', 'Lille', 'jack.lambert@gmail.com', 'fit4life'),
    ('musicAddict', 'Klara', 'Fabre', '1998-06-09', 'Dijon', 'klara.fabre@gmail.com', 'melody90'),
    ('foodieX', 'Leo', 'Bertrand', '1995-05-13', 'Rennes', 'leo.bertrand@gmail.com', 'foodLover56'),
    ('historyBuff', 'Mia', 'Giraud', '1994-11-17', 'Angers', 'mia.giraud@gmail.com', 'pastIsCool'),
    ('photogirl', 'Nathan', 'Baron', '1997-02-28', 'Reims', 'nathan.baron@gmail.com', 'snapIt'),
    ('movieFan', 'Olivia', 'Simon', '1992-08-08', 'Toulon', 'olivia.simon@gmail.com', 'movies4ever'),
    ('catLover', 'Paul', 'Renard', '1996-09-05', 'Caen', 'paul.renard@gmail.com', 'catsAreCool'),
    ('traveler', 'Quentin', 'Mallet', '1993-07-12', 'Montpellier', 'quentin.mallet@gmail.com', 'seeTheWorld'),
    ('nightOwl', 'Sophie', 'Perret', '1999-03-18', 'Saint-Etienne', 'sophie.perret@gmail.com', 'lateNight'),
    ('beachBum', 'Thomas', 'Guillot', '2000-01-30', 'La Rochelle', 'thomas.guillot@gmail.com', 'sandAndSea'),
    ('techLover', 'Ursula', 'Martel', '1998-05-07', 'Clermont-Ferrand', 'ursula.martel@gmail.com', 'techGeek12'),  
    ('ecoWarrior', 'Victor', 'Lemoine', '1997-09-11', 'Paris', 'victor.lemoine@gmail.com', 'ecoGreen'),
    ('speedster', 'Wendy', 'Lefevre', '1995-04-20', 'Lyon', 'wendy.lefevre@gmail.com', 'fastTrack'),
    ('dramaQueen', 'Xavier', 'Laurent', '1999-08-23', 'Brest', 'xavier.laurent@gmail.com', 'dramaKing101'),
    ('mountainLover', 'Yasmine', 'Duval', '1996-12-01', 'Chamonix', 'yasmine.duval@gmail.com', 'highPeaks'),
    ('coffeeAddict', 'Zachary', 'Martin', '2001-02-17', 'Rouen', 'zachary.martin@gmail.com', 'javaTime'),
    ('sportsFan', 'Anastasia', 'Petit', '1993-06-30', 'Metz', 'anastasia.petit@gmail.com', 'scoreIt'),
    ('cityExplorer', 'Bruno', 'Girard', '1994-09-09', 'Nantes', 'bruno.girard@gmail.com', 'urbanTales'),
    ('fitnessGuru', 'Camille', 'Lopez', '1998-11-11', 'Lille', 'camille.lopez@gmail.com', 'getFit99'),
    ('dogLover', 'Dylan', 'Mercier', '1995-01-15', 'Perpignan', 'dylan.mercier@gmail.com', 'dogsAreBest'),
    ('globetrotter', 'Eleanor', 'Bouvier', '2000-07-25', 'Lyon', 'eleanor.bouvier@gmail.com', 'worldTour'),
    ('techSavvy', 'François', 'Morel', '1996-03-13', 'Amiens', 'francois.morel@gmail.com', 'techPro'),
    ('poetHeart', 'Gaelle', 'Noël', '1997-05-09', 'Tours', 'gaelle.noel@gmail.com', 'verseMagic'),
    ('adventureSeeker', 'Henri', 'Rolland', '1994-10-01', 'Annecy', 'henri.rolland@gmail.com', 'thrill4life'),
    ('artFanatic', 'Inès', 'Charpentier', '1998-02-14', 'Bordeaux', 'ines.charpentier@gmail.com', 'artsy98'),
    ('foodHunter', 'Julien', 'Rousseau', '1995-06-19', 'Reims', 'julien.rousseau@gmail.com', 'yumSeek'),
    ('streetStyle', 'Karim', 'Durand', '1992-09-27', 'Toulouse', 'karim.durand@gmail.com', 'swagStyle99'),
    ('filmCritic', 'Lea', 'Garnier', '1997-04-18', 'Nice', 'lea.garnier@gmail.com', 'cinema99'),
    ('fashionista', 'Matthieu', 'Bertin', '1999-12-22', 'Clermont-Ferrand', 'matthieu.bertin@gmail.com', 'styleMeUp'),
    ('skyGazer', 'Nina', 'Reynaud', '1994-08-05', 'Marseille', 'nina.reynaud@gmail.com', 'starrySky'),
    ('bookLover', 'Oscar', 'Vidal', '2001-10-30', 'Toulon', 'oscar.vidal@gmail.com', 'pageTurner99');


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

INSERT INTO user_log (id_user, id_log)
VALUES  
    (1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1), (7, 1), (8, 1), (9, 1), 
    (10, 1), (11, 1), (12, 1), (13, 1), (14, 1), (15, 1), (16, 1), (17, 1), 
    (18, 1), (19, 1), (20, 1);

INSERT INTO user_genre (id_user, id_genre)
VALUES  
    (1, 1), (2, 2), (3, 2), (4, 1), (5, 2), (6, 1), (7, 2), (8, 1), 
    (9, 2), (10, 3), (11, 2), (12, 1), (13, 2), (14, 3), (15, 2), 
    (16, 1), (17, 1), (18, 2), (19, 1), (20, 3), (21, 1), (22, 2),
    (23, 3), (24, 2), (25, 1), (26, 2), (27, 1), (28, 2), (29, 1),
    (30, 2), (31, 1), (32, 2), (33, 1), (34, 2), (35, 1), (36, 1),
    (37, 3), (38, 1), (39, 2), (40, 1);

INSERT INTO user_hobby (id_user, id_hobby) 
VALUES
    (1, 6), (1, 4), (1, 5),
    (2, 4), (2, 1), (2, 7),
    (3, 6), (3, 5), (3, 4),
    (4, 7), (4, 2), (4, 1),
    (5, 7), (5, 1), (5, 5),
    (6, 2),
    (7, 1), (7, 4),
    (8, 6),
    (9, 3), (9, 8),
    (10, 5),
    (11, 1), (11, 5),    
    (12, 2), (12, 3), (12, 7),       
    (13, 2), (13, 4), (13, 1),                     
    (14, 7), (14, 1), (14, 5),                     
    (15, 4), (15, 2),                     
    (16, 3), (16, 1),                    
    (17, 7), (17, 5), (17, 4),                    
    (18, 4), (18, 6), (18, 2),                    
    (19, 7), (19, 1), (19, 2), (19, 5),           
    (20, 1), (20, 6),                    
    (21, 5), (21, 3), (21, 2),                    
    (22, 5), (22, 7), (22, 4),                    
    (23, 4), (23, 1), (23, 7),                    
    (24, 7), (24, 5), (24, 3),                     
    (25, 1), (25, 2), (25, 4),                     
    (26, 5),           
    (27, 7), (27, 2),                 
    (28, 5),                  
    (29, 3), (29, 7),    
    (30, 7), (30, 5), (30, 1),   
    (31, 6), (31, 4),      
    (32, 2), (32, 4), (32, 1),   
    (33, 5), (33, 7), (33, 4),    
    (34, 1), (34, 7), (34, 2),  
    (35, 2), (35, 3), (35, 5), (35, 7),    
    (36, 4), (36, 7), (36, 1),     
    (37, 4), (37, 5), (37, 2),    
    (38, 1), (38, 2), (38, 3), (38, 7),  
    (39, 5), (39, 1), 
    (40, 2), (40, 7), (40, 4);
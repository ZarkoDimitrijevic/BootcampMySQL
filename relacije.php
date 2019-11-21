<?php
//relacija 1 na 1
CREATE TABLE IF NOT EXISTS `korisnici`
(
    `id` INT,
    `ime` VARCHAR(40),
    PRIMARY KEY (`id`)
)

CREATE TABLE IF NOT EXISTS `profili`
(
	`id` INT,
    `adresa` VARCHAR(255),
    `telefon` VARCHAR(25),
    `korisnik_id` INT UNIQUE NOT NULL,//to je kod veze 1 na 1, kod veze 1 na N ne sme biti UNIQUE 
    PRIMARY KEY (`id`),
    FOREIGN KEY `profili`(`korisnik_id`) REFERENCES `korisnici`(`id`) //tako povezujemo te dve tabele
);

// relacije 1 na vise
CREATE TABLE IF NOT EXISTS `objave`
(
	`id` INT,
    `naslov`VARCHAR(45),
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `komentari`
(
	`id` INT,
    `tekst_komentara` VARCHAR(100),
    `id_objave` INT,//i kao sto se vidi nije unique
    PRIMARY KEY (`id`),
    FOREIGN KEY `komentari`(`id_objave`) REFERENCES `objave`(`id`)
);

//relacije vise na vise

CREATE TABLE IF NOT EXISTS `kategorije`
(
	`id` INT,
    `naziv`VARCHAR(45),
    PRIMARY KEY (`id`)
);

    //objave smo vec napravili

CREATE TABLE IF NOT EXISTS `kategorije_imaju_objave`
(
	`id_kategorije` INT,
    `id_objave` INT,
    FOREIGN KEY (`id_kategorije`) REFERENCES `kategorije`(`id`),
    FOREIGN KEY (`id_objave`) REFERENCES `objave`(`id`)
);




CREATE TABLE IF NOT EXISTS `muzika`.`kompozicije`
(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
    `naziv` VARCHAR(30),
    `trajanje` DECIMAL(9,2),
    `id_periodi` INT,
    FOREIGN KEY `id_periodi` REFERENCES `periodi`(`id`)
);

CREATE TABLE IF NOT EXISTS `muzika`.`komponuje`
(
	`id` INT  AUTO_INCREMENT PRIMARY KEY,
    `id_kompozicije` INT,
    `id_kompozitori` INT,
    `opus` VARCHAR(255),
    FOREIGN KEY (`id_kompozicije`) REFERENCES `kompozicije`(`id`),
    FOREIGN KEY (`id_kompozitori`) REFERENCES `kompozitori`(`id`)
);

CREATE TABLE IF NOT EXISTS `muzika`.`svira`
(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_kompozicije` INT,
    `id_instrumenti` INT,
    `broj_instrumenata` TINYINT,
    FOREIGN KEY (`id_kompozicije`) REFERENCES `kompozicije`(`id`),
    FOREIGN KEY (`id_instrumenti`) REFERENCES `instrumenti`(`id`)
);


INSERT INTO `periodi`(`naziv`)
VALUES('Klasicizam'), ('Romantizam'), ('Barok')


//ZADACI
SELECT * FROM `kompozicije` WHERE `trajanje`>15;
SELECT * FROM `kompozitori` WHERE `ime` LIKE 'B%';
SELECT * FROM `kompozicije` ORDER BY `trajanje` DESC LIMIT 1;
SELECT * FROM `kompozicije` WHERE `trajanje` = (SELECT MAX(`trajanje`) FROM `kompozicije`);




?>
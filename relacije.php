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

//POVEZIVANJE VISE TABELA U OKVIRU JEDNOG UPITA
//INNER JOIN
SELECT `kompozicije`.`naziv`, `periodi`.`naziv` //navodimo tabelu.kolonu, pa drugu tabelu.kolonu
FROM `kompozicije` //ili prva ili druga tabela
INNER JOIN `periodi` //ako je gore bila prva tabela, onda je ovde druga i obratno
ON `periodi`.`id`=`kompozicije`.`id_periodi` //kazes po cemu se vezuju ove tabele i tako period.id je foreign key u kompozicijama

SELECT `kompozicije`.`naziv`, `periodi`.`naziv` 
FROM `kompozicije` 
INNER JOIN `periodi` 
ON `periodi`.`id`=`kompozicije`.`id_periodi`
WHERE `periodi`.`naziv` LIKE 'barok'//dodato WHERE, uvek ide na kraju, moras da navedes i tabelu i polje

//ako imas dve tabele koje medjusobno nisu povezane, onda moras da ides preko trece koja je u vezi sa obe
SELECT `kompozicije`.`naziv`,`kompozitori`.`ime`, `kompozitori`.`prezime`//iz II tabele idu dve kolone
FROM `kompozicije`//kompoziciju spajamo na
INNER JOIN `komponuje`//komponnuje
ON `kompozicije`.`id` = `komponuje`.`id_kompozicije`
INNER JOIN `kompozitori`//pa na nju spajamo kompozitore
ON `komponuje`.`id_kompozitori` = `kompozitori`.`id`

//pregled iz tri tabele
SELECT `kompozicije`.`naziv`, `instrumenti`.`naziv`, `svira`.`broj_instrumenata`
FROM `kompozicije`
INNER JOIN `svira`
ON `kompozicije`.`id` = `svira`.`id_kompozicije`
INNER JOIN `instrumenti`
ON `svira`.`id_instrumenti` = `instrumenti`.`id`

//pregled iz tri tabele sa CONCAT funkcijom
SELECT `kompozicije`.`naziv`, CONCAT (`instrumenti`.`naziv`, '-' , `svira`.`broj_instrumenata`)
FROM `kompozicije`
INNER JOIN `svira`
ON `kompozicije`.`id` = `svira`.`id_kompozicije`
INNER JOIN `instrumenti`
ON `svira`.`id_instrumenti` = `instrumenti`.`id`

//ZADACI
SELECT * FROM `instrumenti`
WHERE `naziv` LIKE '%viol%';

SELECT `kompozicije`.`naziv`, `periodi`.`naziv`
FROM `kompozicije`
INNER JOIN `periodi`
ON `kompozicije`.`id_periodi` = `periodi`.`id`
WHERE `periodi`.`nazive` IN ('Barok', 'Romantizam')

SELECT `kompozicije`.`naziv`, `kompozicije`.`trajanje`, `periodi`.`naziv`
FROM `kompozicije`
INNER JOIN `periodi`
ON `kompozicije`.`id_periodi` = `periodi`.`id`

//upit sa ubacenim AS
SELECT `kompozicije`.`naziv` AS 'naziv kompozicije', `kompozicije`.`trajanje`, `periodi`.`naziv` AS 'naziv perioda'
FROM `kompozicije`
INNER JOIN `periodi`
ON `kompozicije`.`id_periodi` = `periodi`.`id`

UPDATE `instrumenti`
SET `tip` = 'duvacki'
WHERE `id` = 7 OR `id` = 9 OR `id` = 10

SELECT `kompozicije`.`naziv`, `instrumenti`.`naziv`
FROM `kompozicije`
INNER JOIN `svira`
ON `kompozicije`.`id` = `svira`.`id_kompozicije`
INNER JOIN `instrumenti`
ON `svira`.`id_instrumenti` = `instrumenti`.`id`;

SELECT `kompozicije`.`naziv`, `kompozitori`.`ime`
FROM `kompozicije`
INNER JOIN `komponuje`
ON `kompozicije`.`id` = `komponuje`.`id_kompozicije`
INNER JOIN `kompozitori`
ON `komponuje`.`id_kompozitori` = `kompozitori`.`id`
WHERE `kompozitori`.`prezime` LIKE '%Betoven'

//ubaceni alijasi
SELECT `k`.`naziv`, `kompoz`.`ime`//ne moze ovde alijas jer je onda on za prikaz kolone, vec samo na fromu i innerjoinu
FROM `kompozicije` AS `k`
INNER JOIN `komponuje` AS `kom`
ON `k`.`id` = `kom`.`id_kompozicije`
INNER JOIN `kompozitori` AS `kompoz`
ON `kom`.`id_kompozitori` = `kompoz`.`id`
WHERE `kompoz`.`prezime` LIKE '%Betoven'

//pretraga po srednoj tabeli, ako ga ima u srednjoj tabeli, znaci ima ga i u daljoj vezi
SELECT DISTINCT `kompozitori`.`ime`, `kompozitori`.`prezime`
FROM `kompozitori`
INNER JOIN `komponuje`
ON `kompozitori`.`id` = `komponuje`.`id_kompozitori`

//mnogo tabela, treba da se nadje logican sled veza
SELECT `kompozicije`.`naziv`, `kompozicije`.`trajanje`, `kompozitori`.`ime`, `kompozitori`.`prezime`, `periodi`.`naziv`
FROM `periodi`
INNER JOIN `kompozicije`
ON `periodi`.`id`=`kompozicije`.`id_periodi`
INNER JOIN `komponuje`
ON `kompozicije`.`id` = `komponuje`.`id_kompozicije`
INNER JOIN `kompozitori`
ON `komponuje`.`id_kompozitori` = `kompozitori`.`id`
ORDER BY `kompozicije`.`trajanje` DESC LIMIT 1

SELECT `kompozitori`.`ime`, `kompozitori`.`prezime`, `kompozicije`.`naziv`, `kompozicije`.`trajanje`
FROM `kompozicije`
INNER JOIN `komponuje`
ON `kompozicije`.`id` = `id_kompozicije`
INNER JOIN `kompozitori`
ON `komponuje`.`id_kompozitori` = `kompozitori`.`id`
WHERE `kompozicije`.`trajanje` BETWEEN 5 AND 25

SELECT `kompozitori`.`ime`, `kompozitori`.`prezime`, `periodi`.`naziv`
FROM `kompozitori`
INNER JOIN `komponuje`
ON `kompozitori`.`id` = `komponuje`.`id_kompozitori`
INNER JOIN `kompozicije`
ON `komponuje`.`id_kompozicije` = `kompozicije`.`id`
INNER JOIN `periodi`
ON `kompozicije`.`id_periodi` = `periodi`.`id`
WHERE `periodi`.`naziv` LIKE 'klasicizam'

SELECT DISTINCT `instrumenti`.`naziv`, `instrumenti`.`tip`, `periodi`.`naziv`
FROM `instrumenti`
INNER JOIN `svira`
ON `instrumenti`.`id` = `svira`.`id_instrumenti`
INNER JOIN `kompozicije`
ON `svira`.`id_kompozicije` = `kompozicije`.`id`
INNER JOIN `periodi`
ON `kompozicije`.`id_periodi` = `periodi`.`id`
WHERE `periodi`.`naziv` LIKE 'klasicizam'

//brojanje sa upitom vezanih tabela
SELECT COUNT(DISTINCT `instrumenti`.`naziv`)  AS 'Broj instrumenata u Betovenovim kompozicijama'
FROM `instrumenti`
INNER JOIN `svira`
ON `instrumenti`.`id` = `svira`.`id_instrumenti`
INNER JOIN `kompozicije`
ON `svira`.`id_kompozicije` = `kompozicije`.`id`
INNER JOIN `komponuje`
ON `kompozicije`.`id` = `komponuje`.`id_kompozicije`
INNER JOIN `kompozitori`
ON `komponuje`.`id_kompozitori` = `kompozitori`.`id`
WHERE `kompozitori`.`prezime` LIKE '%betoven'

SELECT COUNT(`kompozicije`.`naziv`) AS 'Broj Betovenovih kompozicija'
FROM `kompozicije`
INNER JOIN `komponuje`
ON `kompozicije`.`id` = `komponuje`.`id_kompozicije`
INNER JOIN `kompozitori`
ON `komponuje`.`id_kompozitori` = `kompozitori`.`id`
WHERE `kompozitori`.`prezime` LIKE '%betoven'

//vrlo zanimljivo: PREBROJATI KOLIKO SE RAZLICITIH INSTRUMENATA POJAVLJUJE U DELIMA IZ TABELE
SELECT COUNT(DISTINCT `id_instrumenti`) FROM `svira`//gledali smo ID srednje tabele







?>
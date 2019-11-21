<?php
//brisanje tabele u bazi
DROP TABLE `itbootcamp`.`tasks`;

//brisanje citave baze
DROP DATABASE `itbootcamp`;

//kreiranje baze podataka
CREATE DATABASE IF NOT EXISTS `firma`
CHARACTER SET utf16
COLLATE utf16_slovenian_ci;

//redefinisanje tipa kolone
ALTER TABLE `profili` MODIFY `korisnik_id` INT UNIQUE NOT NULL;

//naknadno dodavanje AUTO_INCREMENTa
ALTER TABLE `kompozitori` MODIFY COLUMN `id` INT AUTO_INCREMENT;


//selektovanje baze, to znaci da cemo nadalje koristiti tu bazu
USE `firma`; 

//kreiranje tabela
CREATE TABLE IF NOT EXISTS `firma`.`potrosaci`
(
	`id` INT UNIQUE NOT NULL,
    `korisnicko_ime` VARCHAR(20) UNIQUE NOT NULL,
    `ime_prezime` VARCHAR(60) NOT NULL,
    `godine` TINYINT,
    `drzava` VARCHAR(50),
    `adresa` VARCHAR(100),
    `plata` DECIMAL(16,2),
    PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS `firma`.`zadaci`
(
    `id` INT UNIQUE NOT NULL PRIMARY KEY,
    `naslov` VARCHAR(100) NOT NULL,
    `datum_pocetka` DATE,
    `datum_kraja` DATE,
    `stat` TINYINT,
    `opis` TEXT,
    `prioritet` INT DEFAULT 1
);

//dodavanje kolone u postojecu tabelu
ALTER TABLE `potrosaci` 
ADD COLUMN `god_rodjenja` INT;

//modifikovanje kolone u tabeli, menjamo joj tip podataka koji se skladiste
ALTER TABLE `firma`.`potrosaci`
MODIFY `god_rodjenja` CHAR(4);

//brisanje kolone iz tabele
ALTER TABLE `firma`.`potrosaci`
DROP `god_rodjenja`;

//unos podataka u tabelu (obrati paznju kako se datumi specificno pisu)
INSERT INTO `firma`.`potrosaci` (`id`, `korisnicko_ime`, `ime_prezime`, `godine`, `drzava`, `adresa`, `plata`)
VALUES (1, 'Neko', 'Neki Nekic', 22, 'Srbija', 'Neka adresa nn', 50000),
	   (2, 'Miki', 'Miki Mikic', 25, 'Slovenija', 'Slovenacka bb', 70000),
       (3, 'Piki', 'Piki Pikic', 32, 'Austrija', 'Austrijska bb', 100000.25),
       (4, 'Niki', 'Niki Nikic', 41, 'Australija', 'Australijska bb', 120000),
       (5, 'Riki', 'Riki Rikic', 45, 'Brazil', 'Brazilska bb', 130000);

INSERT INTO `firma`.`zadaci` (`id`, `naslov`, `datum_pocetka`, `datum_kraja`, `stat`, `opis`, `prioritet`)
VALUES (1, 'Brz', '2019-11-18', '2020-11-20', 0, 'Uraditi zadatak brzo', 1),
	   (2, 'Spor', '2019-11-20', '2020-11-22', 0, 'Uraditi zadatak sporo', 2),
       (3, 'Medium', '2019-11-19', '2019-11-20', 0, 'Uraditi zadatak srednje brzo', 1);

//selektovanje podataka iz tabele
SELECT `id`, `ime_prezime`, `korisnicko_ime` 
FROM `firma`.`potrosaci`;

SELECT * FROM `firma`.`potrosaci`;

//ZADATAK 1
SELECT * FROM `firma`.`potrosaci`;//sve iz tabele
SELECT `ime_prezime`, `godine` FROM `firma`.`potrosaci`;//imena i godine
SELECT `plata` FROM `firma`.`potrosaci`; //samo plata

SELECT * FROM `firma`.`zadaci`;//sve iz tabele
SELECT `naslov`, `stat`, `prioritet` FROM `firma`.`zadaci`;//naslov, status, prioritet

//selektovanje razlicitih podataka iz tabele
SELECT DISTINCT `drzava` FROM `firma`.`potrosaci`;
SELECT DISTINCT `korisnicko_ime`, `drzava` FROM `firma`.`potrosaci`; //u ovom slucaju trazi da vrednosti u obe kolone budu raziciti

//ZADATAK 2
SELECT DISTINCT `drzava` FROM `firma`.`potrosaci`; //selektovanje razlicitih drzava
SELECT DISTINCT `plata` FROM `firma`.`potrosaci`; //selektovanje razlicitih plata
SELECT DISTINCT `stat` FROM `firma`.`zadaci`; //razliciti status
SELECT DISTINCT `prioritet` FROM `firma`.`zadaci`;//razliciti prioritet

//selektovanje sa filterom - sa matematickim operatorima
SELECT `id`, `ime_prezime`, `korisnicko_ime`, `godine`
FROM `firma`.`potrosaci`
WHERE `godine`>30;

//uporedjivanje stringova
SELECT * FROM `firma`.`potrosaci` 
WHERE `drzava` 
LIKE 'Srbija'; //za string se ne koriste matematicki operatori vec naredba LIKE

SELECT * FROM `firma`.`potrosaci` WHERE `plata`>50000;
SELECT * FROM `firma`.`zadaci` WHERE `stat`= 0;
SELECT * FROM `firma`.`zadaci` WHERE `prioritet`>2;

//filtriranje sa %
SELECT * FROM `firma`.`potrosaci` WHERE `ime_prezime` LIKE 'J%';
SELECT * FROM `firma`.`potrosaci` WHERE `ime_prezime` LIKE '%i%';
SELECT * FROM `firma`.`potrosaci` WHERE `ime_prezime` LIKE '%a';
SELECT * FROM `firma`.`potrosaci` WHERE `korisnicko_ime` LIKE 'J%a';
SELECT * FROM `firma`.`potrosaci` WHERE `korisnicko_ime` LIKE 'M%o%ic';//pr: Milojic, Milojevic ...
SELECT * FROM `firma`.`zadaci` WHERE `datum_pocetka` LIKE '2019%';


//filtriranje sa donjom crtom koja menja jedan znak (bilo koji)
SELECT * FROM `firma`.`potrosaci` WHERE `korisnicko_ime` LIKE 'Jova_a';

/*operatori:
> strogo vece
< strogo manje
>= vece ili jednako
<= manje ili jednako
!= razlicito
<> razlicito
NOT razlicito
BETWEEN 5 AND 15 izmedju (5 i 15), s tim sto ukljucuje i pocetnu i krajnju vrednost
IN ("Srbija", "Crna Gora", "Australja") pr: SELECT * FROM `potrosaci` WHERE `drzava` IN ("Srbija", "Crna Gora", "Australja")
OR ili (mozes da ne koristis IN, a koristis ovo OR izmedju navodjenja zemalja i svaki put moras where `drzava` like `srbija`OR `drzava` like `australija` itd)
*/

//ZADACI
SELECT * FROM `potrosaci` WHERE `plata` BETWEEN 30000 AND 80000;//selektuje sve koji imaju platu izmedju 30 i 80k
SELECT * FROM `potrosaci` WHERE `drzava` IN ('Srbija', 'Rumunija', 'Bugarska')//selektuje sve redove gde su ove zemlje
SELECT * FROM `potrosaci` WHERE `drzava` LIKE 'S%';//selektuje sve ciji naziv drzave pocinje sa S

SELECT * FROM `zadaci` WHERE `id` IN (1, 4, 8, 12);//selektuje se gde id pripada datom skupu
SELECT * FROM `zadaci` WHERE `datum_pocetka` > '2019-01-01';//selektuje sve gde je datum pocetka veci od datog
SELECT * FROM `zadaci` WHERE `stat` != 0; //selektuje sve ciji je status razlicit od 0

//filtriranje i stavljanje LIMITa
SELECT * FROM `potrosaci` LIMIT 2; //prikazace samo dva rezultata


//ZADACI - istovremeni uslovi i dr.
SELECT * FROM `potrosaci` WHERE `drzava` LIKE 'Srbija' AND `plata` > 50000;//istovremeni uslov
SELECT * FROM `potrosaci` WHERE `ime_prezime` LIKE 'S%' OR `godine` < 30;
SELECT * FROM `zadaci` WHERE `stat` = 0 AND `prioritet` > 0;
SELECT * FROM `zadaci` WHERE `datum_pocetka` < '2019-01-01'

//ORDER
SELECT * FROM `potrosaci` ORDER BY `ime_prezime`, `plata` DESC//kada imamo iste, prvo se sortiraju prema imenu, a ako su ista, onda i po plati
SELECT * FROM `potrosaci` ORDER BY `ime_prezime` DESC, `plata` ASC//mozes i ovako da kombinujes, ASC je default

//ZADATAK
SELECT * FROM `potrosaci` WHERE `plata`>500*118;
SELECT * FROM `potrosaci` WHERE `plata`>500*118 ORDER BY `plata` DESC, `ime_prezime` ASC LIMIT 3;

//DOPUNJAVANJE BAZE
ALTER DATABASE `videoteka` CHARACTER SET 'utf16' COLLATE 'utf16_slovenian_ci';


//INT UNSIGNED - tako mu kazemo da ne moze da taj broj bude negativan

/*AUTO_INCREMENT - sam broji i popunjava,
mozemo samo 1 kolona u tabeli da ima ovo i ta kolona mora biti primarni kljuc*/
CREATE TABLE IF NOT EXISTS `videoteka`.`filmovi`(
    `id` INT UNSIGNED AUTO_INCREMENT,
    `naslov` VARCHAR(255) NOT NULL,
    `reziser` VARCHAR(255) NOT NULL,
    `god_izdanja` YEAR NOT NULL, //tip podatka je YEAR
    `zanr` VARCHAR(255) NOT NULL,
    `ocena` DECIMAL(4,2),//4 decimale, a dve iza zareza
    PRIMARY KEY(`id`)
);

//update polja
UPDATE `videoteka`.`filmovi`
SET `god_izdanja`=1996
WHERE `id`=6

//ZADACI
SELECT * FROM `filmovi` WHERE `zanr` IN ('tragedija', 'komedija', 'drama');
SELECT * FROM `filmovi` WHERE `ocena` BETWEEN 7 AND 10;

SELECT DISTINCT `reziser` FROM `filmovi` WHERE `god_izdanja`>2003 ORDER BY `reziser` ASC;//kompleksan
SELECT DISTINCT `naslov`, `reziser` FROM `filmovi` WHERE `god_izdanja`>1950 ORDER BY `reziser` ASC;//u ovom slucaju i naslov i reziser bi morali da budu isti da bi ih upit odbacio, u suprotnom se prikazuju
SELECT * FROM `filmovi` WHERE `zanr`!= 'komedija' ORDER BY `naslov` DESC;

SELECT * FROM `filmovi` ORDER BY `ocena` DESC LIMIT 1;//nadjemo onog sa najvisom ocenom
SELECT * FROM `filmovi` WHERE `zanr` LIKE 'drama' ORDER BY `ocena` DESC LIMIT 1;
SELECT DISTINCT `reziser` FROM `filmovi` ORDER BY `ocena` DESC LIMIT 3;

//CONCAT - spajanje stringova
SELECT CONCAT(`naslov`, ' (', `reziser`, ')') FROM `filmovi` ORDER BY `naslov`, `reziser`; //neogranicen broj dodavanja stringova u okviru zagrada
SELECT CONCAT(`naslov`, ' (', `reziser`, ')'), `god_izdanja` FROM `filmovi` ORDER BY `naslov`, `reziser`; //kombinacija posle CONCATa

//CONTACT AS - davanje imena spojenom stringu koji se vidi samo prilikom citanja(ne menja strukturu tabele)
SELECT CONCAT(`naslov`, ' (', `reziser`, ')') AS `film`, `god_izdanja` AS `GI` FROM `filmovi` ORDER BY `naslov`, `reziser`;


//MIN(), MAX(), AVG(), SUM(), COUNT() - vracaju samo jedan broj, i bez PODUPITA, ne mozes da kombinujes i da trazis i druge prikaze, jer nece da vrati tacno
SELECT MIN(`ocena`) FROM `filmovi`;
SELECT MAX(`ocena`) AS `namestena` FROM `filmovi`;
SELECT AVG(`ocena`) FROM `filmovi`;
SELECT SUM(`ocena`) FROM `filmovi`;
SELECT COUNT(`naslov`) FROM `filmovi`;
SELECT COUNT(`naslov`) AS `broj_filmova` FROM `filmovi` WHERE `god_izdanja` > 2000;

//PODUPIT
SELECT * FROM `potrosaci` 
WHERE `drzava` LIKE 'Srbija'
AND `plata` = 
    (SELECT MAX(`plata`) FROM `potrosaci` WHERE `drzava` LIKE 'Srbija');

SELECT * FROM `potrosaci` 
WHERE `drzava` = 'Srbija' AND `grad` NOT LIKE 'Beograd' 
AND `plata` > 
    (SELECT AVG(`plata`) FROM `potrosaci` WHERE `drzava` = 'Srbija' AND `grad` NOT LIKE 'Beograd' AND `godine`>20)
ORDER BY `ime_prezime`;



























?>
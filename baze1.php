<?php
SELECT `ime_prezime` FROM `potrosaci` WHERE `ime_prezime` LIKE 'Neki%' OR `ime_prezime` LIKE 'Miki%';
SELECT `adresa`, `ime_prezime`FROM `potrosaci` WHERE `drzava` LIKE 'Srbija' ORDER BY `ime_prezime` ASC;
SELECT `adresa`, `ime_prezime` FROM `potrosaci` WHERE `drzava` = 'Amerika' AND (`adresa` LIKE 'Blvd&' OR `adresa` LIKE 'Ave%');
SELECT * FROM `potrosaci` WHERE `drzava` IN ('Austrija', 'Slovenija', 'Australija') ORDER BY `drzava` ASC, `ime_prezime` DESC

ALTER TABLE `potrosaci` ADD COLUMN `grad`VARCHAR(30) AFTER `godine`;//FIRST (kazu nema before)
UPDATE `potrosaci` SET `grad`='Beograd' WHERE `id` BETWEEN 115 AND 200;
SELECT * FROM `potrosaci` WHERE `drzava` LIKE 'Srbija' AND `grad` NOT IN ('Beograd', 'Nis');
SELECT MAX(`plata`) FROM `potrosaci` WHERE `drzava` LIKE 'Srbija' AND `grad` NOT IN ('Nis', 'Novi Sad');//kada je IN to znaci tacno tako, samo kod LIKE moze %
SELECT AVG(`plata`) FROM `potrosaci` WHERE `drzava` LIKE 'Srbija' AND `grad` NOT LIKE 'Nis';
SELECT MIN(`plata`) FROM `potrosaci` WHERE `ime_prezime` LIKE 'Miki%';
SELECT SUM(`plata`) FROM `potrosaci` WHERE `godine`>30,
SELECT MAX(`godine`) FROM `potrosaci` WHERE `adresa` NOT LIKE '%adresa%';








?>
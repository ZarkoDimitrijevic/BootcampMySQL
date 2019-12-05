<?php
require_once 'dm_konekcija.php';

$upit1 = 
("CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL
) ENGINE = InnoDB;");//engine se stavlja iskljucivo kod kreiranja tabela

/*
ENGINE MyIsam ne proverava strane kljuceve,
ENGINE InnoDB proverava strane kljuceve u smislu njihove vrednosti, da li postoje
*/

$upit1 = 
$upit1 . ("CREATE TABLE IF NOT EXISTS `profiles`(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED UNIQUE,
    `name` VARCHAR(255) NOT NULL,
    `dob` DATE NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE = InnoDB;");

$upit1 = 
$upit1 . ("CREATE TABLE IF NOT EXISTS `follow`(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NOT NULL,
    `friend_id` INT UNSIGNED NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`friend_id`) REFERENCES `users`(`id`)
) ENGINE = InnoDB;");

if($konekcija->multi_query($upit1))
{
    echo "Uspesno izvrsen upit!";
}
else
{
    echo "Doslo je do greske!" . $konekcija->error;
}

?>
<?php 

$db = new PDO("mysql:host=localhost;dbname=muzika", 'root', '');

$filltable = $db->prepare
(
    "INSERT INTO periodi(naziv)
    VALUES 
    ('Klasicizam'), 
    ('Romantizam'),
    ('Barok');
    
    INSERT INTO kompozitori(ime, prezime)
    VALUES
    ('Johan', 'Sebastijan Bah'),
    ('Volfgang', 'Amadeus Mocart'),
    ('Bendzamin', 'Britn'),
    ('Bela', 'Bartok'),
    ('Ludvig', 'van Betoven');

    INSERT INTO instrumenti(naziv)
    VALUES
    ('Klavir'),
    ('Violina'),
    ('Flauta'),
    ('Ksilofon'),
    ('Triangl'),
    ('Harfa'),
    ('Harmonika'),
    ('Gitara'),
    ('Truba'),
    ('Oboa');

    INSERT INTO kompozicije(naziv, trajanje, id_periodi)
    VALUES
    ('Deveta simfonija', 45, 1),
    ('Mala nocna muzika', 15, 1),
    ('Tokata i fuga u dmolu', 9, 3);

    INSERT INTO komponuje(id_kompozicije, id_kompozitori)
    VALUES
    (1, 5),
    (2, 2),
    (3, 1); "
);

$filltable->execute();

$query1=$db->prepare
(
    "SELECT *
    FROM kompozicije
    WHERE trajanje>15"
);
$query1->execute();
$a=$query1->fetchall();
var_dump($a);


$query2=$db->prepare
(
    "SELECT *
    FROM kompozitori
    WHERE ime LIKE 'B% OR prezime LIKE 'B%';"
);
$query2->execute();
$b=$query2->fetchall();
var_dump($b);



$query3=$db->prepare
(
    "SELECT *
    FROM kompozitori
    WHERE ime LIKE 'B%B%';"
);
$query3->execute();
$c=$query3->fetchall();
var_dump($c);



$query4=$db->prepare
(
    "SELECT *
    FROM kompozicije
    WHERE trajanje = (SELECT MAX(trajanje) FROM kompozicije);"
);
$query4->execute();
$c=$query4->fetchall();
var_dump($c);


?>

<!DOCTYPE html>
<html>
    <head>
        <style>
            .error
                {color:red;
                font-weight:bold;
                font-size:28px;}
            table
                {text-align:center;
                vertical-align:center;
                margin-left:auto;
                margin-right:auto;
                border:1px solid black;}
            .table
                {text-align:center;}
        </style>
    </head>
    <body>
        
    

<?php
/*
//kreiraj novog korisnika baze:
CREATE USER 'videoman'@'localhost' IDENTIFIED WITH mysql_native_password AS '***';
GRANT ALL PRIVILEGES ON *.* TO 'videoman'@'localhost' 
REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON `videoteka`.* TO 'videoman'@'localhost';

*/ 

//konekcija nad bazom
$servername = 'localhost';
$username = 'videoman';
$password = '123';
$database = 'videoteka';
/*
$conn = new mysqli($servername, $username, $password, $database);//prva tri su obavezna, jer moze neko da ima privilegiju da napravi bazu

/*
if($conn->connect_error)
{
    die('Connection failed: ' . $conn->connect_error);
}
else
{
    echo 'Uspela konekcija!';
}
/* nakon izvrsenja fajla, konekcija nad bazom se zavrsava, zatvara se, medjutim
ako ti treba ranije zatvaranje, onda ides $conn->close*/

/*$query1 = "INSERT INTO `filmovi` (`naslov`, `reziser`, `god_izdanja`, `zanr`, `ocena`)
            VALUES ('OPET', 'Bas on', 1999, 'komedija', 5),
                    ('Kill Bill', 'Kventin Tarantino', 2003, 'akcija', 8.1)";

if($conn->query($query1))
{
    echo 'Uspesan upis u bazu!';
}
else
{
    echo 'Connection error: ' . "<br>" . $conn->error;
}*/
/*
$conn1 = new mysqli($servername, $username, $password);

if($conn1->connect_error)
{
    die('Connection failed ' . $conn1->connect_error);
}
else
{
    echo 'Uspesna konekcija';
}

$query2 = "CREATE DATABASE IF NOT EXISTS `ambulanta` CHARACTER SET 'utf16' COLLATE 'utf16_slovenian_ci'";

if($conn1->query($query2))
{
    echo '<p>Uspeno kreiranje baze</p>';
}
else
{
    echo '<p>Doslo je do greske<p>' . $conn1->error;
}

$query3 = "USE `ambulanta`;" ;
$query3 .= "CREATE TABLE IF NOT EXISTS `pacijenti`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `ime` VARCHAR(60) NOT NULL,
    `prezime` VARCHAR(120) NOT NULL,
    `broj_kartona` CHAR(10),
    `visina` DECIMAL(5,2),
    `tezina` DECIMAL(5,2),
    `pol` CHAR(1)
)";

if($conn1->multi_query($query3))//multi_query ako ima vise upita, a query ako je samo jedan, u suprotnom puca
{
    echo 'Uspesno kreirana tabela';
}
else
{
    echo 'Doslo je do greske' . $conn1->error;
}*/
$konekcija = new mysqli($servername, $username, $password);
$konekcija->set_charset('utf8');

if($konekcija->connect_error)
die("<div class = 'error'>Desila se greska " . $konekcija->connect_error . "</div>");
/*$insertAmbulanta = 
(
    "INSERT INTO `ambulanta`.`pacijenti`(`ime`, `prezime`, `broj_kartona`, `visina`, `tezina`, `pol`)
    VALUES ('Mika', 'Mikic', '123456', 180, 80, 1 ),
            ('Tika', 'Tikic', '654321', 179, 82, 1 ),
            ('Cica', 'Cicic', '246216', 175, 61, 2 );
    
    ALTER TABLE `ambulanta`.`pacijenti` ADD COLUMN `datum_rodjenja` DATE AFTER `broj_kartona`;

    UPDATE `ambulanta`.`pacijenti` SET `datum_rodjenja` = '2019-12-10' WHERE `id`=1;
    UPDATE `ambulanta`.`pacijenti` SET `datum_rodjenja` = '2019-12-08' WHERE `id`=2;
    UPDATE `ambulanta`.`pacijenti` SET `datum_rodjenja` = '2019-12-07' WHERE `id`=3;
    "
);

/*if($konekcija->multi_query($insertAmbulanta))
{
    echo 'Uspesno';
}
else
{
    echo 'Greska ' . $konekcija->error;
}


$insertVideoteka = 
(
    "CREATE TABLE IF NOT EXISTS `videoteka`.`filmovi`
    (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `naziv` VARCHAR(120),
        `zanr` VARCHAR(30),
        `reziser` VARCHAR(120),
        `godina_izdanja` DATE
    );
    
    INSERT INTO `videoteka`.`filmovi` (`naziv`, `zanr`, `reziser`, `godina_izdanja`)
    VALUES('Neki film', 'neki', 'Neko Nekic', '2000-12-10'),
        ('Opet film', 'eeeeee', 'Piki Pekic', '2001-12-11');"
);

if($konekcija->multi_query($insertVideoteka))
{
    echo 'Bravo, upisao si!';
}
else
{
    echo 'Greska!' . $konekcija->error;
}*/

//prikazivanje podataka
$selektovanje = 
(
    "SELECT `ime`, `prezime`, `visina`, `tezina` FROM `ambulanta`.`pacijenti`"
);

$result = $konekcija->query($selektovanje);

//var_dump($result->fetch_assoc());

/*if($result === false)
{
    echo "<div class = 'error'>Greska u upitu</div>" . $konekcija->error;
}
else
{
    //Upit je dobar, sto znaci da je $result objekat
    if($result->num_rows==0)
    {
        echo "<div class='error'>Nema trazenih podataka!</div>";
    }
    else
    {
        echo "<ul>";
        while($row = $result->fetch_assoc())
        {
            
            echo "<li>Pacijent: " . $row['ime'] . ' ' . $row['prezime'] . ' ' . $row['visina'] . "</li>";
        }
        echo "</ul>";
    }

}*/
/*
if($result===false)
{
    echo "<div class = 'error'> Greska u upitu</div>";
}
else
{
    if($result->num_rows==0)
    {
        echo "<div class = 'error'> Nema rezultata</div>";
    }
    else
    {
        echo "<div class='table'><table>";
        echo "<th>Ime</th>" . "<th>Prezime</th>" . "<th>Visina</th>" . "<th>Tezina</th>";
        while($row = $result->fetch_assoc())
        {
            echo "<tr>";
            echo "<td>" . $row['ime'] . "</td>" . "<td>" . $row['prezime'] . "</td>" . "<td>" . $row['visina'] . "</td>" . "<td>" . $row['tezina'] . "</td>";
            echo "</tr>";
        }
        echo "</table></div>";
    }
}
*/

$selectVideoteka = 
(
    "SELECT * FROM `videoteka`.`filmovi` ORDER BY `naziv` ASC;"
);

$result = $konekcija->query($selectVideoteka);

while($row = $result->fetch_assoc())
{
    echo "<p>" . $row['naziv'] . " " . $row['zanr'] . " " . $row['reziser'] . " " . $row['godina_izdanja'] . "</p>";
}

echo "<br>";

$selectVideoteka1=
(
    "SELECT * FROM `videoteka`.`filmovi` ORDER BY `ocena` DESC, `naziv` ASC"
);

$result1 = $konekcija->query($selectVideoteka1);

while($row = $result1->fetch_assoc())
{
    echo "<p>" . $row['naziv'] . " " . $row['zanr'] . " " . $row['reziser'] . " " . $row['godina_izdanja'] . " " . $row['ocena'] . "</p>";
}

echo "<br>";



$selectzanr=
(
    "SELECT DISTINCT `zanr` FROM `videoteka`.`filmovi`"
);

$result3 = $konekcija->query($selectzanr);
if($result3->num_rows==0)
{
    echo "<p>Nema filmova u bazi</p>";
}
else 
{
    while($row = $result3->fetch_assoc())
    {
        $zanr = $row['zanr'];
        $filmovizanra = 
        ("SELECT * FROM `videoteka`.`filmovi` WHERE `zanr` = '$zanr' ORDER BY `naziv`");
        $resultfilmovi = $konekcija->query($filmovizanra);
        echo "<table>";
        echo "<tr><th colspan = 4>Filmovi sa zanrom: $zanr</th></tr>";
        echo "<tr><th>Naslov</th> <th>Ocena</th> <th>Godina</th> </tr>";
        while($row1 = $resultfilmovi->fetch_assoc())
        {
            echo "<tr>";
            echo "<td>" . $row1['naziv'] . "</td>";
            echo "<td>" . $row1['reziser'] . "</td>";
            echo "<td>" . $row1['ocena'] . "</td>";
            echo "<td>" . $row1['godina_izdanja'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

$selectgodina=
(
    "SELECT DISTINCT `godina_izdanja` FROM `videoteka`.`filmovi`"
);

$rezultat = $konekcija->query($selectgodina);
if($rezultat->num_rows==0)
{
    echo "<p>Nema filmova u bazi</p>";
}
else 
{
    while($red = $rezultat->fetch_assoc())
    {
        $godina = $red['godina_izdanja'];
        $filmovigodine = 
        ("SELECT * FROM `videoteka`.`filmovi` WHERE `godina_izdanja` = '$godina' ORDER BY `godina_izdanja` DESC");
        $resultgodine = $konekcija->query($filmovigodine);
        echo "<table>";
        echo "<tr><th colspan = 4>Filmovi sa zanrom: $godina</th></tr>";
        echo "<tr><th>Naslov</th> <th>Ocena</th> <th>Godina</th> </tr>";
        while($row3 = $resultgodine->fetch_assoc())
        {
            echo "<tr>";
            echo "<td>" . $row3['naziv'] . "</td>";
            echo "<td>" . $row3['reziser'] . "</td>";
            echo "<td>" . $row3['ocena'] . "</td>";
            echo "<td>" . $row3['godina_izdanja'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}




?>

</body>
</html>
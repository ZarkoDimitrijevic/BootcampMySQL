<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>
        

<?php 

require_once 'dm_konekcija.php';

$id=3;//id logovanog korisnika

$upit = 
("SELECT u.id, u.username, p.user_id, p.name, p.dob FROM users AS u
INNER JOIN profiles AS p
ON u.id = p.user_id
WHERE u.id !=$id
ORDER BY p.name;");

$rezultat = $konekcija->query($upit);

if($rezultat->num_rows==0)//da li uopste ima redova
{
    echo "<div class='error'>Vaza mreza nema korisnike :(</div>";
}
else
{
    echo "<ul>";
    while($row = $rezultat->fetch_assoc())
    {
        $friend_id = $row['id'];
        $godiste = substr($row['dob'], 0, 4);
        echo "<li>";
        if($godiste%2==0)
        {
            echo "<span class='parna'><a href=''>" . $row['name'];
        }
        else
        {
            echo "<span class='neparna'><a href=''>" . $row['name'];
        }
        echo "(" . $row['username'] . ")" . "</a></span>";

        $upitFollow = 
        ("SELECT * FROM `follow` WHERE `user_id` = $id AND `friend_id`= $friend_id");

        $rezultat1 = $konekcija->query($upitFollow);

        if($rezultat1->num_rows == 0)
        {
            echo "<a href='dm_prati.php?friend_id=$friend_id'>Zaprati</a> ";//dodavacemo parametre adresi
        }
        else
        {
            echo "<a href='dm_otprati.php?friend_id=$friend_id'>Otkazi pracenje</a>";//pravimo nove stranice jer na taj nacin krijemo od korisnika sta stavljamo u GET
        }
        
        
        echo "</li>";
    }
    echo "</ul>";
}

//$konekcija->set_charset('utf8'); setovanje baze preko specijalne funkcije



?>



    </body>
</html>
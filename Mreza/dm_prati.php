<!DOCTYPE html>
<html>
    <head>
    </head>

    <body>

<?php
    session_start();
    require_once 'dm_konekcija.php';
    $friend_id = 
        $konekcija->real_escape_string($_GET['friend_id']); //i to skuplja iz URLa ono sto smo mu poslali kroz url, dakle GET skuplja iz URLa, mozes da posaljes sta god hoces i koliko hoces, pocinjes znakom pitanja '?', nastavljas umpersentom '&'
        //ova real_escape_string mora da se radi da bi se sprecili sql injection-i, dakle da neko zloupotrebi i ubrizga nesto sto ne bi trebalo

    var_dump($friend_id);
    $id=$_SESSION['id'];//na primer id logovanog korisnika

    $sql = ("SELECT * FROM `follow` WHERE `user_id` = $id AND `friend_id` = $friend_id");

    $result = $konekcija->query($sql);

    if($result->num_rows==0)
    {
        $sql1 = 
        ("INSERT INTO `follow` (`user_id`, `friend_id`)
        VALUES ($id, $friend_id);");
    }

    $result1 = $konekcija->query($sql1);

    if(!$result1)
    {
        die('Neuspeli upit: ' . $konekcija->error);
    }

    header('Location: dm_prijatelji.php');



?>    
    </body>
</html>



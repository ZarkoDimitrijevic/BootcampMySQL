<?php
session_start();

require_once 'dm_konekcija.php';

$friend_id = $konekcija->real_escape_string($_GET['friend_id']);
$id=$_SESSION['id'];//logovani korisnik, u ovom slucaju onaj koji brise pracenje
var_dump($_GET['friend_id']);

$sql = ("DELETE FROM `follow` WHERE `user_id` = $id AND `friend_id` = $friend_id");

$result = $konekcija->query($sql);

if(!$result)
{
    die("Neuspeli upit" . $konekcija->error);
}

header('Location: dm_prijatelji.php'); //vraca nas na stranu
?>
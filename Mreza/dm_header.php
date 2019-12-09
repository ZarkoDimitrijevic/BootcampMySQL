<!DOCTYPE html>
<?php
session_start();
require_once 'dm_konekcija.php';

//provera da li je logovan
if(empty($_SESSION['id']))
{
    header('Location: dm_login.php');
}


?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>

        <ul class="menu">
            <li>
                <a href="dm_prijatelji2.php">Prijatelji</a>
            </li>
            <li>
                <a href="dm_izmeniprofil">Moj profil</a>
            </li>
            <li>
                <a href="dm_logout">Logout</a>
            </li>
        </ul>

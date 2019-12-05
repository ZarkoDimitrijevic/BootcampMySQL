<?php
$server = 'localhost';
$user = 'root';
$password = '';
$database = 'mreza';

$konekcija = new mysqli($server, $user, $password, $database);

if($konekcija->connect_error)
{
    die('Doslo je do greske' . $konekcija->connect_error);
}
?>
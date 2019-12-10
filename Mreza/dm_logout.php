<?php
session_start();

if(isset($_SESSION['id']))//pitamo da li sesija postoji na ovaj nacin, kad je popunjen bilo koji podatak u sesiji, sesija postoji
    {
        session_unset();//uvek se obe pozivaju, unset brise vrednosti ostavlja kljuceve
        session_destroy();//ubija sesiju, znaci brise sve
        header('Location: dm_login.php');
    }

?>
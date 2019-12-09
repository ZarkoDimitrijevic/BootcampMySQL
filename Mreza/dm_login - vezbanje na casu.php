<!DOCTYPE html>
<?php
    //otvaranje sesije je po pravilu na pocetku php fajla
    session_start();

    require_once 'dm_konekcija.php';
    $username_error = $password_error = '*';

    //da li smo na stranicu dosli POST metodom
    if($_SERVER['REQUEST_METHOD'] == 'POST') //moze da se koristi i ovaj nacin, ovde samo ispitujemo da li je metoda POST, odnosno GET
    {
        //korisnik je poslao username i password i pokusava logovanje
        $username = $konekcija->real_escape_string($_POST['username']);
        $password = $konekcija->real_escape_string($_POST['password']);

        if(empty($username))
        {
            $username_error = 'Korisnicko ime ne sme biti prazno!';
        }

        if(empty($password))
        {
            $password_error = 'Polje password ne sme biti prazno!';
        }
        if(!empty($username) && !empty($password))
        {
            $sql = 
            ("SELECT * FROM users WHERE username = '$username'");
            $result = $konekcija->query($sql);

            if($result)
            {
                if($result->num_rows==0)
                {
                    $username_error = 'Ne postoji korisnik sa unetim korisnickim imenom';
                }
                else
                {
                    //postoji korisnicko ime, treba proveriti sifru
                    $row=$result->fetch_assoc();
                    $sifra = $row['password'];
                    if($sifra!=$password)
                    {
                        $password_error = 'Pogresna lozinka';
                    }
                    else
                    {
                        //ovde vrsimo logovanje
                        $_SESSION['id'] = $row['id'];//sami dajemo promenljive i vrednosti
                        header('Location: dm_prijatelji.php');

                    }
                }
            }
            else
            {
                echo "Doslo je do greske" . $konekcija->error;
            }
        }
        
    }
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <nav>
            <h1>Dobrodosli na stranicu za logovanje!</h1>
        </nav>
        <hr>
        <div class="login">
        <fieldset>
            <legend>Login</legend>
            <form action="dm_login-vezbanje na casu.php" method="POST">
                <label for="">Unesite username:</label>
                <br>
                <input type="text" name="username">
                <span class = "error"><?php echo $username_error; ?></span>
                <br>
                <label for="">Unesite password:</label>
                <br>
                <input type="password" name="password" id="password">
                <span class = "error"><?php echo $password_error; ?></span>
                <br><br>
                <input type="submit" name="submit" value="Loguj se">
            </form>
        </fieldset>
    </body>

</html>
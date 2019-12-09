<!DOCTYPE html>
<?php

require_once 'dm_header.php';

$id=$_SESSION['id'];
$sql = 
("SELECT `profiles`.`name`, `profiles`.`dob`, `users`.`username`, `users`.`password`
FROM profiles 
INNER JOIN users
ON `users`.`id` = `profiles`.`id`
WHERE `profiles`.`user_id` = $id");
$rezultat = $konekcija->query($sql);

if(!$rezultat)
{
    echo "error" . $konekcija->error;
}
else
{
    echo "bravo";
    $a = $rezultat->fetch_assoc();
    //var_dump($a);
}

$imeError = $datumError = $usernameError = $passwordError = $re_passwordError = '*';

if(isset($_POST['potvrdi']))
{
    $ime = $konekcija->real_escape_string($_POST['ime']);
    $datum = $konekcija->real_escape_string($_POST['datum']);
    $username = $konekcija->real_escape_string($_POST['username']);
    $password = $konekcija->real_escape_string($_POST['password']);
    $re_password = $konekcija->real_escape_string($_POST['re_password']);

    
    if(empty($ime))
    {
        $imeError = 'Niste uneli ime i prezime!';
    }

    if(empty($datum))
    {
        $datumError = 'Niste uneli datum!';
    }

    if(empty($username))
    {
        $usernameError = 'Niste uneli username!';
    }

    if(empty($password))
    {
        $passwordError = 'Niste uneli password!';
    }

    if(empty($re_password))
    {
        $re_passwordError = 'Polje ne moze biti prazno!';
    }

    if($password!==$re_password)
    {
        $re_passwordError = 'Lozinka i ponovljenja lozinka moraju biti isti!';
    }

    if($imeError == '*' && $datumError == '*' && $usernameError == '*' && $passwordError == '*' && $re_passwordError == '*')
    {
    $sql = 
    ("UPDATE `profiles` SET `name` = '$ime', `dob`='$datum' WHERE `user_id`=$id ");

    $result = $konekcija->query($sql);

    if(!$result)
    {
        echo "error" . $konekcija->error;
    }
    else
    {
        echo "bravo";
    }

    $sql = 
    ("UPDATE `users` SET `username` = '$username', `password` = '$password' WHERE `id` = $id");
    $result = $konekcija->query($sql);

    if(!$result)
    {
        echo "error" . $konekcija->error;
    }
    else
    {
        echo "Bravo";
    }
   }
}

?>


        <form action="dm_izmeniprofil.php" method="POST">
            <label for="">Ime i prezime:</label>
            <input type="text" name="ime" value="<?php echo $a['name']; ?>">
            <span class='error'><?php echo $imeError;?></span>
            <br>
            <br>
            <label for="">Datum rodjenja: </label>
            <input type="date" name="datum" value="<?php echo $a['dob']; ?>">
            <span class='error'><?php echo $datumError;?></span>
            <br>
            <br>
            <label for="">Korisnicko ime:</label>
            <input type="text" name="username" value="<?php echo $a['username']; ?>">
            <span class='error'><?php echo $usernameError;?></span>
            <br>
            <br>
            <label for="">Lozinka</label>
            <input type="password" name="password" value="<?php echo $a['password']; ?>">
            <span class='error'><?php echo $passwordError;?></span>
            <br>
            <br>
            <label for="">Potvrdi lozinku</label>
            <input type="password" name="re_password">
            <span class='error'><?php echo $re_passwordError;?></span>
            <br>
            <br>
            <!--Objasnjenje kako chekirati radio button
    <?php
    //$polValue='m';
    ?>

    <input type="radio" name="pol" value="z" <?php //if($polValue == 'z'){echo "checked";}?>>
    <input type="radio" name="pol" value="m" <?php //if($polValue == 'm'){echo "checked";}?>>
    <input type="radio" name="pol" value="o" <?php //if($polValue == 'o'){echo "checked";}?>>
-->
            <input type="submit" name="potvrdi" value="Potvdi">
        </form>

    </body>

    
</html>
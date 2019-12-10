<!DOCTYPE html>
<?php
require_once 'dm_header.php';

$id = $_SESSION['id'];
$sql = 
("SELECT `profiles`.`name`, `profiles`.`dob`, `users`.`username`, `users`.`password`
FROM profiles 
INNER JOIN users
ON `users`.`id` = `profiles`.`user_id`
WHERE `profiles`.`user_id` = $id");
$rezultat = $konekcija->query($sql);

if(!$rezultat)
{
    echo "error" . $konekcija->error;
}
else
{
    //echo "bravo";
    $a = $rezultat->fetch_assoc();
    $imevalue = $a['name'];
    $usernamevalue = $a['username'];
    $datumvalue = $a['dob'];
}

$imeError = $datumError = $usernameError = '*';

if(isset($_POST['potvrdi']))
{
    $ime = $konekcija->real_escape_string($_POST['ime']);
    $datum = $konekcija->real_escape_string($_POST['datum']);
    $username = $konekcija->real_escape_string($_POST['username']);
    
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
    else
    {
        //Proveravamo da nije doslo do poklapanja korisnickih imena
        $sql = 
        ("SELECT username FROM users WHERE id != $id AND username = '$username'");
        $result = $konekcija->query($sql);
        if($result->num_rows > 0)
        {
            $usernameError = "Korisnicko ime je zauzeto!";
        }
        
    }



    if($imeError == '*' && $datumError == '*' && $usernameError == '*')
    {   
        $imevalue=$ime;
        $datumvalue = $datum;
        $usernamevalue = $username;

        $sql = 
        ("UPDATE `profiles` SET `name` = '$ime', `dob`='$datum' WHERE `user_id`=$id ");
        $result = $konekcija->query($sql);

        if(!$result)
        {
            echo "error" . $konekcija->error;
        }
        else
        {
            //echo "bravo";
        }

        $sql = 
        ("UPDATE `users` SET `username` = '$username' WHERE `id` = $id");
        $result = $konekcija->query($sql);

        if(!$result)
        {
            echo "error" . $konekcija->error;
        }
        else
        {
            //echo "Bravo";
        }
   }
   //header('Location: dm_izmeniprofil.php');
}

?>


        <form action="dm_izmeniprofil.php" method="POST">
            <label for="">Ime i prezime:</label>
            <input type="text" name="ime" value="<?php echo $imevalue; ?>">
            <span class='error'><?php echo $imeError;?></span>
            <br>
            <br>
            <label for="">Datum rodjenja: </label>
            <input type="date" name="datum" value="<?php echo $datumvalue; ?>">
            <span class='error'><?php echo $datumError;?></span>
            <br>
            <br>
            <label for="">Korisnicko ime:</label>
            <input type="text" name="username" value="<?php echo $usernamevalue; ?>">
            <span class='error'><?php echo $usernameError;?></span>
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
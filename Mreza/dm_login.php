<!DOCTYPE html>


<script>
    /*function myFunction() 
    {
        var checkbox = document.getElementById('checkbox');
        var password = document.getElementById('password');
        
        if(checkbox.checked==true)
        {
            password.type="text";
        }
        else
        {
            password.type="password";
        }
    }*/

    function myFunction()
    {
        var checkbox = document.getElementById('checkbox');
        var password = document.getElementById('password');
        

        if(checkbox.className=='glyphicon glyphicon-eye-close unchecked')
        {
            checkbox.className='glyphicon glyphicon-eye-open checked';
            password.type="text";
        }
        else 
        {
            checkbox.className="glyphicon glyphicon-eye-close unchecked";
            password.type="password";
        }
        
    }

</script>

<?php 
require_once 'dm_konekcija.php';
$poruka='';

if(isset($_POST['submit']))
{
    $username = $konekcija->real_escape_string($_POST['username']);
    $password = $konekcija->real_escape_string($_POST['password']);


$sql = 
("SELECT * FROM users WHERE username = '$username' AND `password` = '$password'");
$result = $konekcija->query($sql);

if(!$result)
{
    echo "Doslo je do greske u upitu: " . $konekcija->error;
}
else
{
    if($result->num_rows == 1)
    {
        echo "Bravo uspesno logovanje";
        header('Location: dm_prijatelji.php');
    }
    else
    {
        $poruka =  "<p>U bazi ne postoji korisnik sa datim kredencijalima.</p> 
            <p>Ukoliko niste registrovani, molimo Vas da se <a href='dm_registracija.php'>registrujete</a>.</p>";
    }
}
}
?>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
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
            <form action="dm_login.php" method="POST">
                <label for="">Unesite username:</label>
                <br>
                <input type="text" name="username">
                <br>
                <label for="">Unesite password:</label>
                <br>
                <input type="password" name="password" id="password">
                <!--Checkbox-->
                <span id="checkbox" class="glyphicon glyphicon-eye-close unchecked" onclick="myFunction()"></span>   
                <!--<input id='checkbox' type="checkbox" name="prikazipass" onclick="myFunction()">-->
                <br><br>
                <input type="submit" name="submit" value="Loguj se">
            </form>
        </fieldset>
        </div>

        <div class='poruka'> <?php echo $poruka;?> </div>
    </body>

</html>
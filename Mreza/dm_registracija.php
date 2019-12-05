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
    }

    function myFunction1() 
    {
        var checkbox1 = document.getElementById('checkbox1');
        var password1 = document.getElementById('password1');
        
        if(checkbox1.checked==true)
        {
            password1.type="text";
        }
        else
        {
            password1.type="password";
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

    function myFunction1()
    {
        var checkbox1 = document.getElementById('checkbox1');
        var password1 = document.getElementById('password1');
        

        if(checkbox1.className=='glyphicon glyphicon-eye-close unchecked')
        {
            checkbox1.className='glyphicon glyphicon-eye-open checked';
            password1.type="text";
        }
        else 
        {
            checkbox1.className="glyphicon glyphicon-eye-close unchecked";
            password1.type="password";
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
    $re_password = $konekcija->real_escape_string($_POST['password1']);

    if(empty($username) || empty($password) || empty($re_password))
    {
        $poruka = 'Username, Password i ponovljeni Password ne mogu biti prazna polja';
    }
    elseif($password!==$re_password)
    {
        $poruka = 'Ukucani password se ne poklapa sa ukucanim ponovljenim passwordom!';
    }
    else
    {
        $sql = 
        ("INSERT INTO users (`username`, `password`)
            VALUES('$username', '$password')");
        $result = $konekcija->query($sql);

        if(!$result)
        {
            echo "Doslo je do greske u upitu: " . $konekcija->error;
        }
        else
        {
            header('Location:dm_prijatelji.php');
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
            <h1>Dobrodosli na stranicu putem koje mozete postati registrovani korisnik!</h1>
        </nav>
        <hr>
        <div class="login">
        <fieldset>
            <legend>Login</legend>
            <form action="dm_registracija.php" method="POST">
                <label for="">Unesite username:</label>
                <br>
                <input type="text" name="username">
                <br>
                <label for="">Unesite password:</label>
                <br>
                <input type="password" name="password" id="password">
                <span id="checkbox" class="glyphicon glyphicon-eye-close unchecked" onclick="myFunction()"></span>
                <!--<input id='checkbox' type="checkbox" name="prikazipass" onclick="myFunction()">-->
                <br>
                <label for="">Ponovite password:</label>
                <br>
                <input type="password" name="password1" id="password1">
                <span id="checkbox1" class="glyphicon glyphicon-eye-close unchecked" onclick="myFunction1()"></span>
                <!--<input id='checkbox1' type="checkbox" name="prikazipass1" onclick="myFunction1()">-->
                <br><br>
                <input type="submit" name="submit" value="Loguj se">
            </form>
        </fieldset>
        </div>

        <div class='poruka'> <?php echo $poruka;?> </div>
    </body>

</html>
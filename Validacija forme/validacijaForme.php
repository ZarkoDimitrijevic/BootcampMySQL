<!DOCTYPE html>
<html>
    <head>
        <style>
            .error{color:red;}
        </style>
    </head>
<?php
    $imeErr = $prezimeErr = $emailerr = $websiteerr = $komentarerr = $checkboxerr = '*';//zanimljiv nacin dodeljivanja vrednosti
    $ime=$prezime=$pol=$komentar=$website=$checkbox=$email='';
    $prikaz=false;
    $servername='localhost';
    $username='root';
    $password='';
    $database='korisnici';
    $conn=new mysqli($servername, $username, $password, $database);
    if($conn->connect_error)
    {
        die('Dogodila se greska!'.$conn->connect_error);
    }
    else
    {
    if(isset($_POST['posalji']))
        {
            $ime=$_POST['ime'];
            $prezime=$_POST['prezime'];
            $komentar=$_POST['komentar'];
            $website=$_POST['website'];
            //$checkbox=$_POST['checkbox'];Ne smes tako da radis jer ce da buca ako nije cekirano, jer mu je vrednost false, i zbog toga moras da koristis uvek $_POST['checkbox']
            $email=$_POST['email'];
            $pol=$_POST['pol'];

            //VALIDACIJA ZA IME
            if(empty($ime))
            {
                $imeErr="Niste uneli ime!";
            }
            elseif(!ctype_alpha($ime))
            {
                $imeErr="Ime se moze sastojati samo od slovnih karaktera!";
            }

            //VALIDACIJA ZA PREZIME
            if(empty($prezime))
            {
                $prezimeErr="Niste uneli prezime!";
            }
            elseif(!ctype_alpha($prezime))
            {
                $prezimeErr="Prezime se moze sastojati samo od slovnih karaktera!";
            }

            //VALIDACIJA ZA KOMENTAR
            if(strlen($komentar)<15)
            {
                $komentarerr="Komentar ne moze biti kraci od 15 karaktera";
            }

            //VALIDACIJA ZA WEBSITE
            

            //VALIDACIJA ZA PRAVILA KORISCENJA
            if(!isset($checkbox))//koristis isset() funkciju
            {
                $checkboxerr = "Morate prihvatiti pravila!";
            }

            switch($pol)
            {
                case 'm':
                    $pol='m';
                    break;
                case 'z':
                    $pol='z';
                    break;
                case 'd':
                    $pol='d';
                    break;
                
            }
            //ako je sve validno, onda se uploaduje na server sve ovo
            if($imeErr=='*' && $prezimeErr=='*' && $checkboxerr=='*' && $websiteerr=='*' && $komentarerr=='*')
            {
                $prikaz=true;
            }

        }
    }
?>


    <body>
        <form action="" method="POST">
            <label for="">Ime</label>
            <input type="text" name="ime" placeholder="Unesite ime">
            <span class="error"><?php echo $imeErr;?></span>
            <br><br>
            <label for="">Prezime</label>
            <input type="text" name="prezime" placeholder="Unesite prezime">
            <span class="error"><?php echo $prezimeErr;?></span>
            <br><br>
            <label for="">email</label>
            <input type="email" name='email' placeholder="Unesite email">
            <span class="error"><?php echo $emailerr;?></span>
            <br><br>
            <label for="">website</label>
            <input type="text" name="website" placeholder="Unesite website">
            <span class="error"><?php echo $websiteerr;?></span>
            <br><br>
            <label for="">komentar</label>
            <textarea name="komentar" id="" cols="30" rows="5" placeholder="Unesite komentar"></textarea><!--Ako ti nije slepljen ovako zatvoreni tag, onda kad kliknes na to polje, onda ti ne pocinje text od pocetka, vec on to tretira kao spaceove-->
            <span class="error"><?php echo $komentarerr;?></span>
            <br><br>
            <label for="">Pol</label>
            <input type="radio" name="pol" value="z" checked>Zenski<!--On je automatski pokupio value, slicno kao kod select/option taga-->
            <input type="radio" name="pol" value="m">Muski
            <input type="radio" name="pol" value="d">Drugo
            <br><br>
            <label for="">Prihvatate uslove</label>
            <input type="checkbox" name="checkbox">
            <span class="error"><?php echo $checkboxerr;?></span>
            <br><br>
            <input type="submit" name='posalji' value="Pritisni">
            <input type="reset" name='reset' value="Obrisi podatke"><!--Po defaultu brise podatke iz forme-->
        </form>

        <?php 

            if($prikaz)
            {
                echo "<h2>Uneti podaci su:</h2>";
                echo "<p>Ime:" . $ime . "</p>";
                echo "<p>Prezime:" . $prezime . "</p>";
                echo "<p>email:" . $email . "</p>";
                echo "<p>website:" . $website . "</p>";
                echo "<p>komentar:" . $komentar . "</p>";
                echo "<p>Pol:" . $pol . "</p>";
                echo "<p>Prihvaceni uslovi:" . $checkbox . "</p>";

                //insert upit za unos korisnika u bazu podataka
                $sql=
                (
                    "INSERT INTO `korisnici`.`profili` (`ime`, `prezime`, `komentar`, `pol`, `website`,`email`)
                    VALUES('$ime', '$prezime', '$komentar', '$pol', '$website', '$email')"
                );
                if($conn->query($sql))
                {
                    echo "Bravo, uspesan upit!";
                }
                else
                {
                    echo "Doslo je do greske! Upit $sql dao je gresku" . $conn->error;
                }
            }

            $sql1 =
            (
                "SELECT * FROM `korisnici`.`profili`"
            );

            $rezultat = $conn->query($sql1);
            echo "<table>";
            echo "<tr> <th>Ime</th> <th>Prezime</th> <th>Komentar</th> <th>Pol</th> <th>Website</th> <th>email</th> </tr>";
            while($row = $rezultat->fetch_assoc())
            {

                echo "<tr>" . 
                    "<td>". $row['ime'] . "</td>" .
                    "<td>". $row['prezime'] . "</td>" .
                    "<td>". $row['komentar'] . "</td>" .
                    "<td>". $row['pol'] . "</td>" .
                    "<td>". $row['website'] . "</td>" .
                    "<td>". $row['email'] . "</td>" .
                    "</tr>";
            }
            echo "</table>";


        //procitati filter var
        ?>

        <?php
            $upit = 
            ("SELECT * FROM `korisnici`.`profili` ORDER BY `prezime`");

            $zaoption = $conn->query($upit);
            if($zaoption===false)
            {
                echo "Pogresan upit" . $conn->error;
            }
            
            if($zaoption->fetch_assoc()==null)
            {
                echo "Nema rezultata za zadati upit";
            }
            else
            {
                echo "<select name='Korisnici' id=''>";
                while($red = $zaoption->fetch_assoc())
                {
                    echo "<option value=" . $red['id'] . ">" . $red['ime'] . " " . $red['prezime'] . "</option>";
                }   
                echo "</select>";
            }
            
            
            

        ?>
        


    </body>
</html>
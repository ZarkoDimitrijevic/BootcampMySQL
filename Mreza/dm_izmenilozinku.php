<?php
    require_once "dm_header.php";
    $staraerror = $novaerror = $pnovaerror = '*';
    $poruka = '';

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if(empty($_POST['stara']))
        {
            $staraerror = 'Polje ne sme biti prazno';

        }
        if(empty($_POST['nova']))
        {
            $novaerror = 'Polje ne sme biti prazno';

        }
        if(empty($_POST['pnova']))
        {
            $pnovaerror = 'Polje ne sme biti prazno';

        }
        if($staraerror == '*' && $novaerror == '*' && $pnovaerror == '*')
        {
            $stara = $konekcija->real_escape_string($_POST['stara']);
            $nova = $konekcija->real_escape_string($_POST['nova']);
            $pnova = $konekcija->real_escape_string($_POST['pnova']);

            if($nova != $pnova)
            {
                $novaerror = 'Sifre moraju da se poklapaju!';
            }
            else
            {
                $sql = 
                ("SELECT password FROM users WHERE id = " . $_SESSION['id']);
                $result = $konekcija->query($sql);
                $row = $result->fetch_assoc();
                $sifra = $row['password'];
                //$sifra je kodirana sifra iz baze
                if(MD5($stara) != $sifra)
                {
                    $staraerror = 'Pogresna lozinka';
                }
                else
                {
                    $sql = 
                    ("UPDATE users SET password = MD5('$nova') WHERE id = " . $_SESSION['id']);
                    $konekcija->query($sql);
                    $poruka = 'Bravo, uspesno ste promenili sifru!
                        <a href = "dm_prijatelji2.php">Vrati se na pocetak</a>';
                }
            }
        }

    }

?>
<div class="success"><?php echo $poruka;?></div>

<form action="dm_izmenilozinku.php" method="POST">
    <label for="">Stara lozinka: </label>
    <input type="password" name="stara" value="">
    <span class="error"><?php echo $staraerror?></span>
    <br><br>
    <label for="">Nova lozinka: </label>
    <input type="password" name="nova" value="">
    <span class="error"><?php echo $novaerror?></span>
    <br><br>
    <label for="">Ponovite novu lozinku: </label>
    <input type="password" name="pnova" value="">
    <span class="error"><?php echo $pnovaerror?></span>
    <br><br>
    <input type="submit" value="Posalji">

</form>


</body>
</html>
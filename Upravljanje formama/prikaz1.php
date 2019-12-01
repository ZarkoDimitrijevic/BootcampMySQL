<!DOCTYPE html>
<html>
    <head>
    </head>

    <body>
        <?php
            
            if(isset($_POST['ime1']))
            echo "Dobrodosli " . $_POST['ime1'] . ", vas email je: " . $_POST['email1'];//ovo pretpostavlja da su ti sa osnovne strane poslati podaci
        ?>
        <p><a href="UpravljanjeFormama.php">Nazad</a></p>
    </body>
</html>
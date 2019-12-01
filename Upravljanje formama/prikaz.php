<!DOCTYPE html>
<html>
    <head>
    </head>

    <body>
        <?php
            if(isset($_GET['ime']))//ne moze dve stvari u issetu vec mozes da kazes ako $_GET!==0
            {echo "Dobrodosli " . $_GET['ime'] . ", vas email je: " . $_GET['email'];}//ovo pretpostavlja da su ti sa osnovne strane poslati podaci

        ?>
        <p><a href="UpravljanjeFormama.php">Nazad</a></p>
    </body>
</html>
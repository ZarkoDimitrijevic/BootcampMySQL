<!DOCTYPE html>
<html>
    <head>
    </head>

    <body>
        <form action="prikaz.php" method="GET"> <!--Odredjujes stranicu gde saljes podatke, ako ostavis prazno, onda je to ta stranica-->
            <label for="">Ime</label>
            <input type="text" name="ime">
            <br>
            <br>
            <label for="">email</label>
            <input type="email" name="email">
            <br>
            <br>
            <input type="submit" value="potvrdite"><!--Razlika od buttona jer submit odmah skuplja sve iz forme, a kod buttona je drugacije-->
            <!--<button name="btn">Button</button>-->
        </form>

        <form action="prikaz1.php" method="POST" target="_blank"> <!--Odredjujes stranicu gde saljes podatke, ako ostavis prazno, onda je to ta stranica. Ovde smo i stavili target=_blank-->
            <label for="">Ime</label>
            <input type="text" name="ime1">
            <br>
            <br>
            <label for="">email</label>
            <input type="email" name="email1">
            <br>
            <br>
            <input type="submit" value="potvrdite1"><!--Razlika od buttona jer submit odmah skuplja sve iz forme, a kod buttona je drugacije-->
            <!--<button name="btn">Button</button>-->
        </form>

        <?php 
        if(isset($_GET['ime'])) //ako je stavljen button, onda moras da kazes ako je isset button, sa submit, ti direktno gadjas polje koje ti treba, znaci kazes ako je isset to polje.
        {echo $_GET['ime'];}?>
    </body>


</html>

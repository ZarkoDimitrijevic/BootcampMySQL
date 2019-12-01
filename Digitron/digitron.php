<!DOCTYPE hmtl>
<html>
    <head>
        <style>
            .violet{color:violet;}
            
        </style>
    
    </head>

    <body>
        <h2>Kalkulator</h2>
        <hr>
        <form action="" method="POST">
            <label for="">Prvi broj:</label>
            <input type="number" name="prviBroj" value=0>

            <br><br>

            <label for="">Drugi broj:</label>
            <input type="number" name="drugiBroj" value=0>

            <br><br>

            <label for="">Operacija</label>
            <select name="operacija" id=""><!--On sam pamti koja je opcija, zato mi pamtimo name, a on vraca upisani value koji je odabran-->
                <option value="+">Saberi</option>
                <option value="-">Oduzmi</option>
                <option value="*">Pomnozi</option>
                <option value="/">Podeli</option>
            </select>

            <input type="submit" value="RACUNAJ"><!--submit ima value, a button otvoreni i zatvoreni tag gde pises naziv buttona-->
        </form>

        
        <?php
        
            if(isset($_POST['prviBroj']))
            {
                /*if($_POST['operacija'] == '+')
                {
                    echo "<span class='violet'>" . $result = $_POST['prviBroj'] + $_POST['drugiBroj'] . "</span>";
                }
                elseif($_POST['operacija'] == '-')
                {
                    echo $result = $_POST['prviBroj'] - $_POST['drugiBroj'];
                }
                elseif($_POST['operacija'] == '*')
                {
                    echo $result = $_POST['prviBroj'] * $_POST['drugiBroj'];
                }
                else
                {
                    if($_POST['drugiBroj']!=0)
                    {
                        echo $result = $_POST['prviBroj'] / $_POST['drugiBroj'];
                    }
                    else
                    {
                        echo "Nije dozvoljeno deliti nulom!";
                    }
                }*/

                switch($_POST['operacija'])
                {
                    case "+":
                        echo "<span class='violet'>" . $result = $_POST['prviBroj'] + $_POST['drugiBroj'] . "</span>";
                        break;
                    case "-":
                        echo "<span class='violet'>" . $result = $_POST['prviBroj'] - $_POST['drugiBroj'] . "</span>";
                        break;
                    case "*":
                        echo "<span class='violet'>" . $result = $_POST['prviBroj'] * $_POST['drugiBroj'] . "</span>";
                        break;
                    case "/":
                        if($_POST['drugiBroj']!=0)
                        {
                            echo $result = $_POST['prviBroj'] / $_POST['drugiBroj'];
                            break;
                        }
                        else
                        {
                            echo "Nije dozvoljeno deliti nulom!";
                            break;
                        }
                    default://u ovom slucaju ne moze da dodje do defaulta jer je u selectu uvedeno samo ovih 4 operacije
                        echo "Los unos!";
                        

                }
            }
        ?>

    </body>
</html>
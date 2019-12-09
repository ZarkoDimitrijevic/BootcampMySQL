
<?php
    require_once 'dm_header.php';
    
    //Prikazati sve korisnike koji nisu ja
    //1) povezivanje na bazu
    require_once 'dm_konekcija.php';

    //2) prikazati sve korisnike osim logovanih
    $id=$_SESSION['id'];//id logovanog korisnika

    if(!empty($_GET['dodaj']))
    {
        $fid = $konekcija->real_escape_string($_GET['dodaj']);
        $sql1 = 
        ("SELECT * FROM follow WHERE user_id = $id AND friend_id = $fid");
        $result1 = $konekcija->query($sql1);
        if($result1->num_rows==0)
        {
            $sql2 = 
            ("INSERT INTO follow(user_id, friend_id)
                VALUES ($id, $fid);");
            $result2=$konekcija->query($sql2);
            if(!$result2)
            {
                echo "<span class='error'>Neuspesno dodavanje: " . $konekcija->error . "</span>";
            }
        }
        else
        {
            echo "Vec se prati korisnik!";
        }
    }

    if(!empty($_GET['brisi']))
    {
        $fid = $konekcija->real_escape_string($_GET['brisi']);
        $sql1 = 
            ("DELETE FROM follow WHERE user_id = $id AND friend_id = $fid");
        $result1 = $konekcija->query($sql1);
        if(!$result1)
        {
            echo "<span class='error'>Neuspesno brisanje: " . $konekcija->error . "</span>";
        }
    }
    



    $sql = ("SELECT u.username, p.name, p.dob, u.id
            FROM users AS u 
            INNER JOIN profiles AS p
            ON u.id = p.user_id
            WHERE u.id!=$id
            ORDER BY p.name");

    $result = $konekcija->query($sql);
    if(!$result)//pitamo da li ne postoji objekat, ako ne postoji, vrednost ce biti null
    {
        die("<span class='error'>Upit nije uspeo" . $konekcija->error . "</span>
        </body></html>");//posle die se nista ne izvrsava ni html, pa moras da zapises sve sto treba da zatvoris
    }
    else
    {
        if($result->num_rows==0)//izvrsava se nad objektom, pitamo da li ima redova
        {
            echo "<span class='error'>Drustvena mreza nema nijednog korisnika!</span>";
        }
        /*else//moje resenje
        {
            echo "<ul>";
            //ima korisnika i treba ih prikazati
            while($row=$result->fetch_assoc())
            {
                $date = strtotime("now");
                if($date-strtotime($row['dob'])>=18*31536000)
                {
                    echo "<p><span style=color:green>" . $row['username'] . "(" . $row['name'] . ")" . "</span></p>";
                }
                else
                {
                    echo "<p><span style=color:red>" . $row['username'] . "(" . $row['name'] . ")" . "</span></p>";
                }
            }
            echo "</ul>";

            
            
        }*/
        else
        {
            // ima korisnika i treba ih prikazati
            $br = 1;
            echo "<table>";
            echo "<tr>";
            echo "<th>Redni broj</th>";
            echo "<th>Ime i prezime</th>";
            echo "<th>Korisnicko ime</th>";
            echo "<th>Akcije</th>";
            echo "</tr>";

            $trenutno = strtotime("now");

            while($row = $result->fetch_assoc())
            {
                echo "<tr>";
                echo "<td>". ($br++) . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                $osoba = strtotime($row['dob']);
                if($trenutno-$osoba>=18*31536000)
                {
                    echo "<td class='blue'>" . $row['username'] . "</td>";
                    
                }
                else
                {
                    echo "<td class='green'>" . $row['username'] . "</td>";
                }
                $friend_id = $row['id'];

                //ispitujemo da li pratim korisnika
                $sql1 = 
                    ("SELECT * FROM follow WHERE user_id = $id
                        AND friend_id = $friend_id");
                $result1 = $konekcija->query($sql1);
                $jatebe = $result1->num_rows; //moze da bude 0 redova, znaci niko nikoga ne prati, ili 1 red kada pratim korisnika

                //ispitujemo da li korisnik prati mene
                $sql2 = 
                    ("SELECT * FROM follow WHERE user_id = $friend_id
                        AND friend_id = $id");
                $result2 = $konekcija->query($sql2);
                $timene = $result2->num_rows;//opet moze da bude 0 redova ili 1 red

                echo "<td>";
                    if($jatebe == 0)
                    {
                        if($timene==0)
                        {
                            echo "<a href='dm_prijatelji2.php?dodaj=$friend_id'>Zaprati korisnika</a>" . "&nbsp";
                        }
                        else
                        {
                            echo "<a href='dm_prijatelji2.php?dodaj=$friend_id'>Uzvrati pracenje</a>" . "&nbsp";
                        }
                    }
                    else
                    {
                        echo "<a href='dm_prijatelji2.php?brisi=$friend_id'>Otkazi pracenje</a>";
                    }
                    
                    
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
    }
    




?>
    </body>
</html>
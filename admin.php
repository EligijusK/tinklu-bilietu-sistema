<?php
include "sessions.php";
include "header.php";
include "dbh.inc";

if(!empty($_SESSION['administrator'])) {

}
else if(!empty($_SESSION['manager'])) {
    header( "Location: ./manager.php");
    exit();
}
else if(!empty($_SESSION['user'])) {
    header( "Location: ./user.php");
    exit();
}
else
{
    header( "Location: ./login.php");
    exit();
}

if(isset($_POST['submit']) && $_POST['submit'] != "")
{
    $check = 0;
    $data = [];
    foreach ($_POST as $key => $value) {
        if(isset($value) && $value != "")
        {
            array_push($data, mysqli_real_escape_string($sql, $value));
            $check++;
        }
    }
    if($check === 7) // cia turi buti 7 kai tirkinam su atvykimo data, ir atvykimo data reikia ideti kaip atvykimas, su data[4]
    {
        if($data[5] > 0 && $data[4] > 0) {
            $db = "INSERT INTO `tvarkarastis` ( `traukinys`, `isvykimo_miestas`, `atvykimo_miestas`, `isvykimas`, `kaina`, `visos_vietos`, `likusios_vietos`) VALUES ( '" . $data[0] . "', '" . $data[1] . "', '" . $data[2] . "', '" . $data[3] . "', '" . $data[5] . "', '" . $data[4] . "', '" . $data[4] . "')";
            if (mysqli_query($sql, $db)) {
                echo "<h3>
                <center>Maršrutas sėkmingai pridėtas</center>
            </h3>";
            } else {
                echo "<h3>
                <center>Maršruto nepavyko pridėti</center>
            </h3>";
            }
        }
        else if($data[5] <= 0){
            echo "<h3>
                <center>Bilietų kiekis turi būti didesnis už nulį</center>
            </h3>";
        }
        else if($data[4] <= 0){
            echo "<h3>
                <center>Kaina turi būti didesnis už nulį</center>
            </h3>";
        }
    }
}

if(isset($_POST['cancel']) && $_POST['cancel'] != "")
{
    $checkCancel = 0;
    $data = [];
    foreach ($_POST as $key => $value) {
        if(isset($value) && $value != "")
        {
            array_push($data, mysqli_real_escape_string($sql, $value));
            $checkCancel++;
        }
    }
    if($checkCancel === 2 )
    {
        $db = "DELETE FROM tvarkarastis WHERE id = ".$data[0]." ";
        if(mysqli_query($sql,$db))
        {

        }
        else{
            echo mysqli_error($sql);
        }
    }
}


?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto">
            <H2>Maršrutų lentelė</H2>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Traukinys</th>
                <th scope="col">Išvykimo Miestas</th>
                <th scope="col">Atvykimo Miestas</th>
                <th scope="col">Išvykimo laikas</th>
                <th scope="col">Bilieto kaina</th>
                <!--<th scope="col">Atvykimo laikas</th>-->
                <th scope="col">Biletų kiekis</th>
                <!--<th scope="col"></th>
                <th scope="col"></th> -->
            </tr>
            </thead>
            <tbody>
            <?php

            $db  = "SELECT * FROM tvarkarastis";
            if($res = mysqli_query($sql, $db))
            {
                if(mysqli_num_rows($res) > 0)
                {
                    while($row = mysqli_fetch_row($res))
                    {
                        $phpDateOut = strtotime( $row[4] );
                        $mysqlDateOut = date( 'Y-m-d H:i:s', $phpDateOut );

                        $phpDateIn = strtotime( $row[5] );
                        $mysqlDateIn = date( 'Y-m-d H:i:s', $phpDateIn );

                        echo "<tr>
                                <th scope=\"row\">".$row[0]."</th>
                                <td>".$row[1]."</td>
                                <td>".$row[2]."</td>
                                <td>".$row[3]."</td>
                                <td>".$mysqlDateOut."</td>
                                <td>".$row[6]."</td>
                                <td>".$row[7]."</td>
                               
                               
                              </tr>";
                    } // <td>".$mysqlDateIn."</td> atvykimo laikas
                      // <td><form method=\"POST\" action='editRoute.php'><input type=\"hidden\" name=\"id\" value='".$row[0]."'><input type='submit' name='edit' value='Redaguoti'></form></td> reiso redagavimas
                      //<td><form method=\"POST\" action=''><input type=\"hidden\" name=\"id\" value='".$row[0]."'><input type='submit' name='cancel' value='Atšaukti reisą'></form></td> reiso atsaukimas
                }
            }

            ?>
            </tbody>
        </table>
    </div>
    <div class="row justify-content-center">
        <div class="col-auto">
            <H2>Pridėti maršrutą</H2>
        </div>
    </div>
    <div class="row">
        <form action="" method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="train">Traukinys</label>
                    <input class="form-control" type="text" pattern=".{6,}" name="train" title="Traukinio pavadinimas turi būti ilgesnis nei 6 raidės" placeholder="Traukinio pavadinimas" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="outCity">Išvykimo Miestas</label>
                    <input class="form-control" type="text" name="outCity" pattern=".{4,}" title="Meisto pavadinimas turi būti ilgesnis nei 4 raidės" placeholder="Miestas iš kurio išvyks traukinys" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="inCity">Atvykimo Miestas</label>
                    <input class="form-control" type="text" name="inCity" pattern=".{4,}" title="Meisto pavadinimas turi būti ilgesnis nei 4 raidės" placeholder="Miestas į kurį atvyks traukinys" required>
                </div>
                <div class="form-group col-lg-6">
                    <label for="train">Išvykimo Laikas</label>
                <input class="form-control" type="datetime-local" name="outData" title="Data ir laikas privalo būti nustatytas" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}" required>
                </div>
                <div class="form-group col-lg-6">
                    <!--    <label for="train">Atvykimo Laikas</label>
                    <input class="form-control" type="datetime-local" name="inData"> -->
                </div>
                <div class="form-group col-md-2">
                <input class="form-control" type="number" name="count" pattern=".{1,}" title="Bilietų kiekis būtinai turi būti nustatytas ir didesnis už nulį"  placeholder="Biletų Skaičius" min="1" required>
                </div>
                <div class="form-group col-md-2">
                    <input class="form-control" type="number" name="price" pattern=".{1,}" title="Bilietų kaina būtinai turi būti nustatyta ir didesnė už nulį" placeholder="Biletų kaina" min="1" required>
                </div>
                <div class="form-group col-auto">
                    <input type="submit" class="btn btn-primary" name="submit" value="Pridėti maršrutą" required>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
<footer>

</footer>
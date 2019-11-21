<?php
include "sessions.php";
include "header.php";
include "dbh.inc";

if(!empty($_SESSION['administrator']) && !empty($_POST['id'])) {
    $id = mysqli_real_escape_string($sql, $_POST['id']);
}
else if(!empty($_SESSION['administrator']) && empty($_POST['id'])) {
    header( "Location: ./admin.php");
    exit();
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
    if($check === 8 )
    {
        $db = "UPDATE tvarkarastis SET traukinys = '".$data[1]."', isvykimo_miestas = '".$data[2]."', atvykimo_miestas = '".$data[3]."', isvykimas = '".$data[4]."', atvykimas = '".$data[5]."', visos_vietos = '".$data[6]."', likusios_vietos = '".$data[6]."' WHERE id = ".$id." ";
        if(mysqli_query($sql,$db))
        {

        }
        else{
            echo mysqli_error($sql);
        }

        $updateCount = LeftTickets($sql, $id);
        $update = "UPDATE tvarkarastis SET likusios_vietos = ".$updateCount." WHERE id = ".$id." ";
        if(mysqli_query($sql, $update))
        {

        }
        else {
            echo mysqli_error($sql);
        }
    }
}


?>

<div class="container">

            <?php

            $db  = "SELECT * FROM tvarkarastis WHERE id=".$id." ";
            if($res = mysqli_query($sql, $db))
            {
                if(mysqli_num_rows($res) > 0)
                {
                    while($row = mysqli_fetch_row($res))
                    {
                        $mysqlDateOut = strftime('%Y-%m-%dT%H:%M:%S', strtotime($row[4]));

                        $mysqlDateIn = strftime('%Y-%m-%dT%H:%M:%S', strtotime($row[5]));

                        echo "  <div class=\"row justify-content-center\">
                                    <div class=\"col-auto\">
                                        <H2>Pridėti maršrutą</H2>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <form action=\"\" method=\"post\">
                                        <div class=\"form-row\">
                                            <input type='hidden' name='id' value='".$id."'>
                                            <div class=\"form-group col-md-4\">
                                                <label for=\"train\">Traukinys</label>
                                                <input class=\"form-control\" type=\"text\" name=\"train\" value='".htmlspecialchars($row[1])."' placeholder=\"Traukinio pavadinimas\">
                                            </div>
                                            <div class=\"form-group col-md-4\">
                                                <label for=\"outCity\">Išvykimo Miestas</label>
                                                <input class=\"form-control\" type=\"text\" name=\"outCity\" value='".htmlspecialchars($row[2])."' placeholder=\"Miestas iš kurio išvyks traukinys\">
                                            </div>
                                            <div class=\"form-group col-md-4\">
                                                <label for=\"inCity\">Atvykimo Miestas</label>
                                                <input class=\"form-control\" type=\"text\" name=\"inCity\" value='".htmlspecialchars($row[3])."' placeholder=\"Miestas į kurį atvyks traukinys\">
                                            </div>
                                            <div class=\"form-group col-lg-6\">
                                                <label for=\"train\">Išvykimo Laikas</label>
                                                <input class=\"form-control\" type=\"datetime-local\" value='".htmlspecialchars($mysqlDateOut)."' name=\"outData\">
                                            </div>
                                            <div class=\"form-group col-lg-6\">
                                            <!--    <label for=\"train\">Atvykimo Laikas</label>
                                                <input class=\"form-control\" type=\"datetime-local\" value='".htmlspecialchars($mysqlDateIn)."' name=\"inData\"> -->
                                            </div>
                                            <div class=\"form-group col-md-2\">
                                                <input class=\"form-control\" type=\"number\" name=\"count\" value='".htmlspecialchars($row[6])."' placeholder=\"Biletų Skaičius\">
                                            </div>
                                            <div class=\"form-group col-auto\">
                                                <input type=\"submit\" class=\"btn btn-primary\" name=\"submit\" value=\"Redaguoti maršrutą\">
                                            </div>
                                        </div>
                                    </form>
                                </div>";
                    }
                }
            }

            ?>

</div>
</body>
<footer>

</footer>
<?php
include "sessions.php";
include "header.php";
include "dbh.inc";

if(!empty($_SESSION['user']) || !empty($_SESSION['manager'])) {

}
else if(!empty($_SESSION['administrator']))
{
    header( "Location: ./admin.php");
    exit();
}
else
{
    header( "Location: ./login.php");
    exit();
}

if(isset($_POST['order']) && $_POST['order'] != "")
{
    $id = mysqli_real_escape_string($sql, $_POST['order']);
    $db = "INSERT INTO biletai (FK_vartotojas, FK_tvarkarastis) VALUE ('".$_SESSION['userID']."', '".$id."')";
    if(mysqli_query($sql, $db))
    {
        echo "<h3>
                <center>Bilietas užsakytas</center>
            </h3>";
    }
    else {
        echo "<h3>
                <center>Bilieto nepavyko užsakytas prašome pabandyti vėliau</center>
            </h3>";
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
if(isset($_POST['discard']) && $_POST['discard'] != "")
{
    $ids = mysqli_real_escape_string($sql, $_POST['id']);
    $id = mysqli_real_escape_string($sql, $_POST['discard']);

    $db = "DELETE FROM biletai WHERE id = ".$id." ";
    if(mysqli_query($sql, $db))
    {
        echo "<h3>
                <center>Bilietas atšauktas</center>
            </h3>";
    }
    else {
        echo "<h3>
                <center>Bilieto nepavyko atšaukti prašome pabandyti vėliau</center>
            </h3>";
    }

    $updateCounts = LeftTickets($sql, $ids);
    $updates = "UPDATE tvarkarastis SET likusios_vietos = ".$updateCounts." WHERE id = ".$ids." ";
    if(mysqli_query($sql, $updates))
    {

    }
    else {
        echo mysqli_error($sql);
    }

}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto">
            <h2>
                Visi maršrutai
            </h2>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Traukinys</th>
                <th scope="col">Išvykimo Miestas</th>
                <th scope="col">Atvykimo Miestas</th>
                <th scope="col">Išvykimo laikas</th>
                <th scope="col">Bilieto kaina</th>
                <!--<th scope="col">Atvykimo laikas</th> -->
                <th scope="col"></th>
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

                        $updateCount = LeftTickets($sql, $row[0]);

                        echo "<tr>
                                <th scope=\"row\">".$row[0]."</th>
                                <td>".$row[1]."</td>
                                <td>".$row[2]."</td>
                                <td>".$row[3]."</td>
                                <td>".$mysqlDateOut."</td>
                                <td>".$row[6]."</td>
                                ";
                        if($updateCount > 0) {  // <td>".$mysqlDateIn."</td> atvykimo laikas
                            echo "<td><form method='post'><button name='order' value='".htmlspecialchars($row[0])."'>Užsisakyti</button></form></td>";
                        }
                        echo "</tr>";
                    }
                }
            }

            ?>
            </tbody>
        </table>
    </div>
    <div class="row justify-content-center">
        <div class="col-auto">
        <h2>Užsakyti bilietai:</h2>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Traukinys</th>
                <th scope="col">Išvykimo Miestas</th>
                <th scope="col">Atvykimo Miestas</th>
                <th scope="col">Išvykimo laikas</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
        <?php

        $db  = "SELECT * 
                FROM biletai 
                INNER JOIN tvarkarastis ON tvarkarastis.id = biletai.FK_tvarkarastis
                INNER JOIN vartotojai ON vartotojai.id = biletai.FK_vartotojas
                WHERE vartotojai.id = ".$_SESSION['userID']." ";
        if($res = mysqli_query($sql, $db))
        {
            if(mysqli_num_rows($res) > 0)
            {
                while($row = mysqli_fetch_row($res))
                {
                    $phpDateOut = strtotime( $row[7] );
                    $mysqlDateOut = date( 'Y-m-d H:i:s', $phpDateOut );
                    echo "<tr>
                                <th scope=\"row\">".$row[0]."</th>
                                <td>".$row[4]."</td>
                                <td>".$row[5]."</td>
                                <td>".$row[6]."</td>
                                <td>".$mysqlDateOut."</td>
                                <td><form method='post'><input type='hidden' name='id' value='".$row[3]."'><button name='discard' value='".htmlspecialchars($row[0])."'>Atšaukti užsakyma</button></form></td>
                              </tr>";
                }
            }
        }



        ?>
            </tbody>
        </table>
    </div>
</div>
</body>
<footer>

</footer>
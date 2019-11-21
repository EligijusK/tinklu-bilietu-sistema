<?php
include "sessions.php";
include "header.php";
include "dbh.inc";

if(!empty($_SESSION['manager'])) {

}
else if(!empty($_SESSION['user'])) {
    header( "Location: ./user.php");
    exit();
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

?>

<div class="container">
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="row">#</th>
                <th scope="row">Traukinys</th>
                <th scope="row">Išvykimo Miestas</th>
                <th scope="row">Atvykimo Miestas</th>
                <!--<th scope="col">Išvykimo laikas</th> -->
                <th scope="row">Atvykimo laikas</th>
                <th scope="row">Bilieto kaina</th>
                <th scope="row">Likusių biletų kiekis</th>
                <td scope="row-md-6" style="width: 100px;"></td>
                <th scope="row">Procentinis reisų užimtumas</th>
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

                        $procentage = (100 / $row[7]) * CountTickets($sql, $row[0]);

                        echo "<tr>
                                <th scope=\"row\">".$row[0]."</th>
                                <td>".$row[1]."</td>
                                <td>".$row[2]."</td>
                                <td>".$row[3]."</td>
                                <td>".$mysqlDateOut."</td>
                                <td>".$row[6]."</td>
                                <td>".$updateCount."</td>
                                <td></td>
                                <td>".$procentage."%</td>
                              </tr>";
                        // <td>".$mysqlDateIn."</td> turi buti po $mysqlDateOut
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

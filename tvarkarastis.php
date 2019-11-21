<?php
include "sessions.php";
include "header.php";
include "dbh.inc";
?>

<div class="container">
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Traukinys</th>
                <th scope="col">Išvykimo Miestas</th>
                <th scope="col">Atvykimo Miestas</th>
                <th scope="col">Išvykimo laikas</th>
                <!-- <th scope="col">Atvykimo laikas</th> -->
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
                                
                              </tr>";
                        //<td>".$mysqlDateIn."</td> galinis elementas
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
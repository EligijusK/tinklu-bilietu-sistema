<?php
$user = "root";
$password = ""; // arba tuscia arba root
$host = "localhost";
$database = "traukiniai";

$sql = mysqli_connect($host, $user, $password);

$createDB = " CREATE DATABASE IF NOT EXISTS traukiniai; ";
if(mysqli_query($sql, $createDB))
{
    $selectDb="USE $database";
    if($res = mysqli_query($sql, $selectDb)) {
    }
    else{
        echo mysqli_error($sql);
    }
}


function Login($username, $password, $sql)
{

        $loginRequest = "SELECT * FROM vartotojai WHERE slapyvardis = '$username' ";
        if ($res = mysqli_query($sql, $loginRequest)) {
            if(mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_row($res)) {

                    if (password_verify($password, $row[5])) {

                        $_SESSION['userID'] = $row[0];
                        $_SESSION['username'] = $row[1];
                        if ($row[6] == 3) {
                            $_SESSION['administrator'] = true;
                            header("Location: ./admin.php?prisijunge");
                        } else if ($row[6] == 2) {
                            $_SESSION['manager'] = true;
                            header("Location: ./manager.php?prisijunge");
                        } else if ($row[6] == 1) {
                            $_SESSION['user'] = true;
                            header("Location: ./user.php?prisijunge");
                        }
                        exit;
                    } else {
                        echo "Prisijungimas nepavyko pasitikrinkite duomenis";
                    }
                }
            }
            else{
                echo "Prisijungimas nepavyko pasitikrinkite duomenis";
            }
        }
}

function LeftTickets($sql, $trainId)
{
    $result = 0;
    $db = " SELECT tvarkarastis.visos_vietos, COUNT(biletai.id)
            FROM `tvarkarastis`
            LEFT JOIN biletai ON biletai.FK_tvarkarastis = tvarkarastis.id
            WHERE tvarkarastis.id = ".$trainId."
            GROUP BY tvarkarastis.id";
    if($res = mysqli_query($sql, $db))
    {
        if(mysqli_num_rows($res) > 0)
        {
            while ($row = mysqli_fetch_row($res))
            {
                    if(empty($row[1]))
                    {
                        $result = $row[0];
                    }
                    else if(!empty($row[1]) && $row[1] > 0) {
                        $result = $row[0] - $row[1];
                    }
            }
        }
    }
    else{
      echo mysqli_error($sql);
    }
    return $result;
}

function CountTickets($sql, $trainId) : int
{
    $result = 0;
    $db = " SELECT tvarkarastis.visos_vietos, COUNT(biletai.id)
            FROM `tvarkarastis`
            LEFT JOIN biletai ON biletai.FK_tvarkarastis = tvarkarastis.id
            WHERE tvarkarastis.id = ".$trainId."
            GROUP BY tvarkarastis.id";
    if($res = mysqli_query($sql, $db))
    {
        if(mysqli_num_rows($res) > 0)
        {
            while ($row = mysqli_fetch_row($res))
            {
                if(!empty($row[1]) && $row[1] > 0) {
                    $result = $row[1];
                }
            }
        }
    }
    else{
        echo mysqli_error($sql);
    }
    return $result;
}
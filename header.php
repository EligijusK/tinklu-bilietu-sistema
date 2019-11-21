<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['logout']) && $_POST['logout'] != "") {

    if (isset($_SESSION['administrator']) || isset($_SESSION['manager']) || isset($_SESSION['user'])) {
        $_SESSION['administrator'] = null;
        $_SESSION['manager'] = null;
        $_SESSION['user'] = null;
        header("Location: ./login.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Traukiniai</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Traukinių biletai</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href = "tvarkarastis.php" > Maršrutų sąrašas </a >
            <?php
            if($_SESSION['user'] != null || $_SESSION['manager'] != null) {
               echo '<a class="nav-item nav-link" href = "user.php" > Vartotojo Zona </a >';
            }

            if($_SESSION['manager'] != null) {
            echo '<a class="nav-item nav-link" href="manager.php">Vadybininko Zona</a>';
            }

            if($_SESSION['administrator'] != null) {
                echo '<a class="nav-item nav-link" href="admin.php">Administratorio Zona</a>';
            }
            if(!isset($_SESSION['administrator']) && !isset($_SESSION['manager']) && !isset($_SESSION['user'])) {
               echo '<a class="nav-item nav-link" href="login.php">Prisijungti</a>';

            }
            else{
                echo '<form name="logout" method="POST"><input type="hidden" name="logout" value="atsijungti"><a onclick="document.logout.submit();" class="nav-item nav-link" href="#">Atsijungti</a></form>';
            }
            ?>
        </div>
    </div>
</nav>
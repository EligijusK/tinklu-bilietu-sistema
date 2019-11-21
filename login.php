<?php
include "sessions.php";
include "header.php";
include "dbh.inc";

if(isset($_POST["prisijungti"]) && $_POST["prisijungti"] == "Prisijungti") {

    $username = mysqli_real_escape_string($sql, $_POST["username"]);
    $pass = mysqli_real_escape_string($sql, $_POST["password"]);

    if ($_POST["username"] == '' && $_POST["password"] == '') {
        echo "Prašome užpildyti visus laukelius";
    }
    else{
        Login($username, $pass, $sql);
    }

}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <form action="" method="POST">
                <input type="text" name="username" pattern=".{5,}" placeholder="Įveskite slapyvardį arba el paštą" title="Slapyvardis turi būti ilgesnis nei 5 raidės" required>
                <input type="password" name="password" pattern=".{5,}" placeholder="Įveskite slaptažodį" title="Slaptažodis turi būti ilgesnis nei 5 raidės" required>
                <input type="submit" name="prisijungti" value="Prisijungti">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <a href="register.php">Prisiregistruokite čia</a>
        </div>
    </div>
</div>
</body>
<footer>

</footer>

<?php
include "sessions.php";
include "header.php";
include "dbh.inc";

if(isset($_POST["register"]) && $_POST["register"] == "Registruotis") {

    $username = mysqli_real_escape_string($sql, $_POST["username"]);
    $name = mysqli_real_escape_string($sql, $_POST["name"]);
    $last = mysqli_real_escape_string($sql, $_POST["last_name"]);
    $email = mysqli_real_escape_string($sql, $_POST["email"]);
    $pass = mysqli_real_escape_string($sql, $_POST["password"]);
    $passCheck = mysqli_real_escape_string($sql, $_POST["passwordCheck"]);
    if ($_POST["username"] == '' || $_POST["name"] == '' || $_POST["last_name"] == '' || $_POST["password"] == '' || $_POST["passwordCheck"] == '' || $_POST["email"] == '') {
        echo "Prašome užpildyti visus laukelius";
    }
    else{
        if ($passCheck === $pass) {
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
            $db = "INSERT INTO vartotojai (slapyvardis, vardas, pavarde, epastas, slaptazodis, tipas)
            VALUES ('$username', '$name', '$last', '$email', '$hashedPassword', 1)";

            if(mysqli_query($sql, $db))
            {
                $info = "Sėkminga registracija";
                header( "Location: ./index.php");
                exit();
            }
            else
            {
                $info = "toks vartotojas su tokiu vartotojo vardu jau egzistuoja";
            }
            echo $info;
        }
        else{
            echo "Prašome įvesti sutampančius slaptažodžius";
        }
    }

}


?>

<div class="container">
    <div class="row">
        <div class="col-lg-1">
            <form action="" method="POST">
                <?php if(!empty($username))
                {
                    echo '<input type="text" name="username" pattern=".{6,}" value="'.htmlspecialchars($username).'" placeholder="Įveskite slapyvardį" title="Slapyvardis turi būti ilgesnis nei 6 raidės" required>';
                }
                else {
                    echo '<input type="text" name="username" pattern=".{6,}" placeholder="Įveskite slapyvardį" title="Slapyvardis turi būti ilgesnis nei 6 raidės" required>';
                }
                ?>
                <?php if(!empty($name))
                {
                    echo '<input type="text" name="name" pattern=".{3,}" value="'.htmlspecialchars($name).'" placeholder="Įveskite vardą" title="Vardas turi būti ilgesnis nei 3 raidės" required>';
                }
                else {
                    echo '<input type="text" name="name" pattern=".{3,}" placeholder="Įveskite vardą" title="Vardas turi būti ilgesnis nei 3 raidės" required>';
                }
                ?>
                <?php if(!empty($last))
                {
                    echo '<input type="text" name="last_name" pattern=".{3,}" value="'.htmlspecialchars($last).'" placeholder="Įveskite pavardę" title="Pavardes ilgis turi būti ilgesnis nei 6 raidės" required>';
                }
                else {
                    echo '<input type="text" name="last_name"  pattern=".{3,}" placeholder="Įveskite pavardę" title="Pavardes ilgis turi būti ilgesnis nei 6 raidės" required>';
                }
                ?>
                <?php if(!empty($email))
                {
                    echo '<input type="email" name="email" value="'.htmlspecialchars($email).'" placeholder="Įveskite el-paštą" title="Prašome nepalikti tuščio laukelio" required>';
                }
                else {
                    echo '<input type="email" name="email" placeholder="Įveskite el-paštą" title="Prašome nepalikti tuščio laukelio" required>';
                }
                ?>
                <input type="password" name="password" pattern=".{8,}" title="Slaptažodio ilgis turi būti ilgesnis nei 8 raidės" placeholder="Įveskite slaptažodį" required>
                <input type="password" name="passwordCheck" pattern=".{8,}" title="Slaptažodio ilgis turi būti ilgesnis nei 8 raidės" placeholder="Pakartokite slaptažodį" required>
                <input type="submit" name="register" value="Registruotis">
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


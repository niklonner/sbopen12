<?php

$user = $_POST['user'];
$passwd = $_POST['passwd'];

if ($user == 'stadium' && $passwd=='23lundby') {
    session_start();
    $_SESSION['login'] = "ok";
    header("Location:loggedin.php");
} else {
    die("Fel användarnamn/lösen");
}

?>


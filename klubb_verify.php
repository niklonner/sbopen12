<?php

include('validate.php');

$res = verify_klubb($_POST['klubb']);

echo ($res ? "ok" : "error");

?>

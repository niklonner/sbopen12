<?php

include('validate.php');

$res = verify_fornamn($_POST['fornamn']);

echo ($res ? "ok" : "error");

?>

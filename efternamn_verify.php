<?php

include('validate.php');

$res = verify_efternamn($_POST['efternamn']);

echo ($res ? "ok" : "error");

?>

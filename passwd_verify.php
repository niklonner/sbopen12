<?php

include('validate.php');

$res = verify_passwd($_POST['passwd']);

echo ($res ? "ok" : "error");

?>

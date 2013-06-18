<?php

include('validate.php');

$res = verify_tfnnummer($_POST['tfnnummer']);

echo ($res ? "ok" : "error");

?>

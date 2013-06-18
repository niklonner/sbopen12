<?php

include('connectdb.php');

$id = $_POST['id'];

$query_string = "SELECT dag,tid FROM PlaysIn WHERE id='$id';";
$query = mysql_query($query_string);

while($res = mysql_fetch_assoc($query))
    echo $res['dag'] . $res['tid'];

include('closedb.php');

?>

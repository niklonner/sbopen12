<?php

include('make_booking.php');

$res = make_booking($_POST);

//everything ok?
if ($res=="dbfault" || $res=="denied") {
    echo $res;
    exit();
}

include('connectdb.php');

$query_string = "SELECT info FROM PlaysIn NATURAL JOIN Starter WHERE id='$res' " .
                    "ORDER BY dag ASC,tid ASC;";
$query = mysql_query($query_string);

echo "<h4>Tack för din anmälan!</h4>" .
    "<p>Du är nu anmäld till följande starter:</p><p>";

while ($arr = mysql_fetch_assoc($query)) {
    echo utf8_encode($arr['info']) . "<br/>";
}

echo "</p>";

include('closedb.php');

?>

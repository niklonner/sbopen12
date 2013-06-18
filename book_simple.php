<?php

include('make_booking.php');

if ($_POST['start1']==-1 && $_POST['start2']==-1) {
    echo "Du måste välja en start.<br/><br/>";
    echo "<a href=\"javascript:history.go(-1)\">Tillbaka</a>";
    exit();
}
if ($_POST['start1'] == $_POST['start2']) {
    echo "Första och andra starten kan inte vara densamma.<br/><br/>";
    echo "<a href=\"javascript:history.go(-1)\">Tillbaka</a>";
    exit();
}

if ($_POST['start1']==-1)
    unset($_POST['start1']);

if ($_POST['start2']==-1)
    unset($_POST['start2']);

$res = make_booking($_POST);

if ($res=="dbfault" || $res=="denied") {
    if ($res=="dbfault")
        echo "Oväntat fel i databasen. Försök igen.<br/><br/>";
    else
        echo "Du har något fel i din anmälan.<br/><br/>";
    echo "<a href=\"javascript:history.go(-1)\">Tillbaka</a>";
} else {

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
    
    echo "<p><a href=\"enkel_anmalan.php\">Tillbaka</a></p>";

    include('closedb.php');
}
?>

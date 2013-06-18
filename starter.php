<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
    <title>Starter</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript">
var chosenStarts = 0;
var starts = new Array();
var maxStarts = 2;

$(function(){



    $("#starter_acc").accordion({ header: "h3",
                              autoHeight: false,
                              collapsible: true,
                              active: false});

});
</script>
</head>
<body>

    <h2>Starter</h2>
    <p> Klicka på en start för mer information.
    </p>
    <div id="starter_acc">
	<h3><a href="#">Alla startande</a></h3>
	<div>
	<table>
<?php

include('connectdb.php');

$query_string = "SELECT* FROM PlayersInStarts;";
$query = mysql_query($query_string);
$prev_id = -1;
$player_ids;
while ($row = mysql_fetch_assoc($query)) {
	if ($row['id']==$prev_id) {
		echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td style='padding-left:50px'>" .
				utf8_encode($row['info']) . " (R)</td></tr>";
	} else {
		echo "<tr><td>" . $row['firstname'] . 
			" " . $row['lastname'] . "</td><td style='padding-left:50px'>" .
			$row['klubb'] . "</td><td style='padding-left:50px'>" .
			utf8_encode($row['info']) . "</td></tr>";
		$prev_id = $row['id'];
		$player_ids[$prev_id] = true;
	}
}

?>
	</table>
	</div>
	
<?php

$query_string = "SELECT* FROM StartAvail";
$query = mysql_query($query_string);
$i = 0;
while ($row = mysql_fetch_assoc($query)) {
    echo "<h3><a href=\"#\">".
        utf8_encode($row['info']) . " (" .
        $row['count'] . "/" .
        $row['platser']. " bokade)" .
        "</a></h3>";
    $query_start_string = "SELECT firstname, lastname, klubb FROM Starter NATURAL JOIN" .
            " PlaysIn NATURAL JOIN Players WHERE dag = ".
            $row['dag'] ." AND tid = ". $row['tid'];
    $query_start = mysql_query($query_start_string);
    if (mysql_num_rows($query_start)==0) {
        echo "<div>Inga startande.</div>";
        continue;
    }
    echo "<div><table>";
    while ($inner_row = mysql_fetch_assoc($query_start)) {
        echo "<tr><td>" .
             $inner_row['firstname'] . " " . 
             $inner_row['lastname'] . " " . 
             "</td><td style=\"padding-left:50px\">" .
             $inner_row['klubb'] . " " . 
             "</td></tr>";
    }
    echo "</table></div>";
}

include('closedb.php');

?>

    </div>
    
</body>
</html>

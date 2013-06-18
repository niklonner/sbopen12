<?php
session_start();

if ($_SESSION['login'] != "ok")
    die("Inte inloggad<br/><br/><a href=\"login.php\">Logga in</a>");

?>

<html>
<head>
    <title>Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
<p>
<a href="logout.php">Logga ut</a>
</p>

<p>
<h2>Alla spelare</h2>
<table>
<?php

include('connectdb.php');

$query_string = "SELECT firstname, lastname, klubb, tfnnummer FROM Players ORDER BY firstname ASC, lastname ASC;";
$query = mysql_query($query_string);

while($row = mysql_fetch_assoc($query)) {
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $klubb = $row['klubb'];
    $tfnnummer = $row['tfnnummer'];
    echo "<tr><td>$firstname $lastname</td>" . 
        "<td style='padding-left:50px'>$klubb</td>" .
        "<td style='padding-left:50px'>$tfnnummer</td></tr>";
}

include('closedb.php');

?>
</table>
</p>
</body>
</html>

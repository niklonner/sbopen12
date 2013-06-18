<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
    <title>Förenklad anmälan</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="css/mainstyle.css" type="text/css">

</head>

<body>

<h2>Förenklad anmälan</h2>
<form name="anmalan" method="POST" action="book_simple.php">
<table>

<tr>
    <td>
        Förnamn:    
    </td>
    <td>
        <input type="text" name="fornamn">
    </td>
    <td>
        Endast bokstäver. Fältet får ej lämnas tomt.
    </td>
</tr>
<tr>
    <td>
        Efternamn:    
    </td>
    <td>
        <input type="text" name="efternamn">
    </td>
    <td>
        Endast bokstäver. Fältet får ej lämnas tomt.
    </td>
</tr>
<tr>
    <td>
        Klubb:    
    </td>
    <td>
        <input type="text" name="klubb">
    </td>
    <td>
        Endast bokstäver och siffror. Fältet får ej lämnas tomt.
    </td>
</tr>
<tr>
    <td>
        Telefonnummer:    
    </td>
    <td>
        <input type="text" name="tfnnummer">
    </td>
    <td>
        Endast siffror. Fältet får ej lämnas tomt.
    </td>
</tr>

<tr>
    <td>
        Välj start 1:
    </td>
    <td>
        <select name="start1">
        <option value=-1>Ingen</option>
<?php
include('connectdb.php');

$query = mysql_query("SELECT* FROM StartAvail");
$i = 0;
while ($row = mysql_fetch_assoc($query)) {
    $disable = $row['count'] == $row['platser'];
    echo "<option value=". $row['dag'] . $row['tid'] . ">" .
        utf8_encode($row['info']) . " (" .
        $row['count']. "/" .
        $row['platser']. " bokade)" .
        "</option>";
}
include('closedb.php');
?>

        </select>
    </td>
    <td>
        &nbsp;
    </td>
</tr>
<tr>
    <td>
        Välj start 2:
    </td>
    <td>
        <select name="start2">
        <option value=-1>Ingen</option>
<?php
include('connectdb.php');

$query = mysql_query("SELECT* FROM StartAvail");
$i = 0;
while ($row = mysql_fetch_assoc($query)) {
    $disable = $row['count'] == $row['platser'];
    echo "<option value=". $row['dag'] . $row['tid'] . ">" .
        utf8_encode($row['info']) . " (" .
        $row['count']. "/" .
        $row['platser']. " bokade)" .
        "</option>";
}
include('closedb.php');
?>        
        </select>
    </td>
    <td>
        &nbsp;
    </td>
</tr>
<tr>
    <td>
        Välj lösenord (för av/ombokning):    
    </td>
    <td>
        <input type="password" name="passwd">
    </td>
    <td>
        Tillåtna tecken a-z, A-Z och 0-9. 6-15 tecken långt. Fältet får ej lämnas tomt.
    </td>
</tr>
<tr>
    <td>
        Ange lösenord igen:
    </td>
    <td>
        <input type="password" name="passwdver">
    </td>
    <td>
        &nbsp;
    </td>
</tr>


</table>

<input type="submit" value="Boka">
</form>
</body>

</html>

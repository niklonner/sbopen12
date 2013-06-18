<?php

include('validate.php');

$password = $_POST['password'];
$id =  $_POST['id'];

if (!verify_id($id))
    exit ("passwd");

if (!verify_passwd($password))
    exit ("passwd");

include('connectdb.php');

$correct_pwd_arr = mysql_fetch_assoc(mysql_query("SELECT passwd FROM Players WHERE id='$id';"));
$correct_pwd = $correct_pwd_arr['passwd'];

//ALTSBoPENS

if ($correct_pwd!=sha1($password . 'ALTSBoPENS') && $password != '23lundby') //hall-login
    exit("passwd");

$query = mysql_query("DELETE FROM PlaysIn WHERE id='$id';");

if (!$query)
    exit("dbfault");

if (isset($_POST['start1'])) {
    $start = substr($_POST['start1'],3);
    if (!verify_start($start))
        exit("dbfault");
    $dag = substr($start,0,6);
    $tid = substr($start,-4);
    $query_string = "INSERT INTO PlaysIn (id,dag,tid) VALUES ('$id','$dag','$tid');";
    $query = mysql_query($query_string);
    if (!$query)
        exit("dbfault");
}
if (isset($_POST['start2'])) {
    $start = substr($_POST['start2'],3);
    if (!verify_start($start))
        exit("dbfault");
    $dag = substr($start,0,6);
    $tid = substr($start,-4);
    $query_string = "INSERT INTO PlaysIn (id,dag,tid) VALUES ('$id','$dag','$tid');";
    $query = mysql_query($query_string);
    if (!$query)
        exit("dbfault");
}
if (!isset($_POST['start1']) && !isset($_POST['start2'])) {
    $query = mysql_query("DELETE FROM Players WHERE id='$id'");
    if (!$query)
        exit("dbfault");
    echo "<h4>Du är nu avanmäld från tävlingen.</h4>";
} else {
    echo "<h4>Ändringarna sparade.</h4><p>Du är nu anmäld till följande starter:</p><p>";
    
    $query_string = "SELECT info FROM PlaysIn NATURAL JOIN Starter WHERE id='$id' " .
                        "ORDER BY dag ASC,tid ASC;";
    $query = mysql_query($query_string);

    while ($arr = mysql_fetch_assoc($query)) {
        echo utf8_encode($arr['info']) . "<br/>";
    }

    echo "</p>";
}

include('closedb.php');
?>

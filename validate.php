<?php


function verify_efternamn($string) {

    $res = preg_match("#^[\p{L}\- ]+$#u", $string);

    return (!(!$res || $res==0));

}

function verify_fornamn($string) {

    $res = preg_match("#^[\p{L}\- ]+$#u", $string);

    return (!(!$res || $res==0));

}

function verify_klubb($string) {

    $res = preg_match("#^[\p{L}\- 0-9]+$#iu", $string);

    return (!(!$res || $res==0));

}

function verify_passwd($string) {

    $res = preg_match("#^[a-z0-9]{6,15}$#i", $string);

    return (!(!$res || $res==0));

}

function verify_tfnnummer($string) {

    $res = preg_match("#^[0-9]{8,15}$#", $string);

    return (!(!$res || $res==0));

}

function verify_id($string) {

    $res = preg_match("#^[0-9]+$#", $string);

    return (!(!$res || $res==0));

}

function verify_start($string) {
    include('connectdb.php');

    $date = substr($string,0,6);
    $time = substr($string,-4);
    $query_string = "SELECT* FROM Starter WHERE dag='$date' AND tid='$time';";
    $query = mysql_query($query_string);
    return mysql_num_rows($query) > 0;
    include('closedb.php');
}

?>

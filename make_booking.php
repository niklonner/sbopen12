<?php

include('validate.php');

function make_booking($param_arr) {

    $i = 0;

    $ok[$i++] = verify_fornamn($param_arr['fornamn']);
    $ok[$i++] = verify_efternamn($param_arr['efternamn']);
    $ok[$i++] = verify_klubb($param_arr['klubb']);
    $ok[$i++] = verify_tfnnummer($param_arr['tfnnummer']);
    $ok[$i++] = verify_passwd($param_arr['passwd']);
    $ok[$i++] = $param_arr['passwd'] == $param_arr['passwdver'];
    $ok[$i++] = verify_start($param_arr['start1']) || verify_start($param_arr['start2']);

    //everything ok?
    foreach ($ok as $ind => $bool)
        if (!$bool) {
            return "denied";
        }

    //insert into database
    include('connectdb.php');

    $fornamn = $param_arr['fornamn'];
    $efternamn = $param_arr['efternamn'];
    $klubb = $param_arr['klubb'];
    $tfnnummer = $param_arr['tfnnummer'];
    $hashed_pwd = sha1($param_arr['passwd'] . 'ALTSBoPENS');
    $start1 = isset($param_arr['start1']) ? $param_arr['start1'] : false;
    $start2 = isset($param_arr['start2']) ? $param_arr['start2'] : false;

    $query_string = "INSERT INTO Players (firstname,lastname,klubb,passwd,tfnnummer) " .
        "VALUES ('$fornamn','$efternamn','$klubb','$hashed_pwd','$tfnnummer');";
    $query = mysql_query($query_string);

    if (!$query) {
        return "dbfault";
    }

    $query_string = "SELECT id FROM Players WHERE firstname='$fornamn' AND lastname='$efternamn' " .
            "AND klubb='$klubb' AND passwd='$hashed_pwd' AND tfnnummer='$tfnnummer';";
    $query = mysql_query($query_string);

    if (!$query) {
        return "dbfault";
    }

    $id_arr_tmp = mysql_fetch_assoc($query);
    $id = $id_arr_tmp['id'];

    if ($start1) {
        $day = substr($start1,0,6);
        $time = substr($start1,-4);
        $query_string = "INSERT INTO PlaysIn (id,dag,tid) VALUES ('$id','$day','$time');";
        $query = mysql_query($query_string);
        if (!$query) {
            return "dbfault";
        }
    }

    if ($start2) {
        $day = substr($start2,0,6);
        $time = substr($start2,-4);
        $query_string = "INSERT INTO PlaysIn (id,dag,tid) VALUES ('$id','$day','$time');";
        $query = mysql_query($query_string);
        if (!$query) {
            return "dbfault";
        }
    }

    //everything ok if here
    include('closedb.php');
    return $id;
}

?>

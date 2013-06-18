<?php

$name = $_POST['name'];
$email = $_POST['email'];
$tfnnummer = $_POST['tfnnummer'];
$message = $_POST['message'];

echo "$name<br/>";
echo "$email<br/>";
echo "$tfnnummer<br/>";
echo strip_invalid($message) . "<br/>";



function strip_invalid($message) {
    if ($message=="")
        return "";
    $tst_char = substr($message,0,1);
    $rest = substr($message,1);
    return ok_char($tst_char) ? $tst_char . strip_invalid($rest)
                                    : strip_invalid($rest);
}

function ok_char($char) {

    $res = preg_match("#^[\p{L}0-9\-\.\+\!\(\), åäö]{1}$#iu", $char);

    return (!(!$res || $res==0));

}

?>

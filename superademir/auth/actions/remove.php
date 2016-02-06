<?php

include("../../../extras/funcs.php");
include("../authfunctions.php");
require_login("borginhos");

$user = req_get("user");

$shadowfile = "../.shadow";

$lines = file($shadowfile);
$count = 0;
foreach ($lines as $line) {
    list($rightuser, $hashed, $salt) = explode("§", $line);
    if ($user == $rightuser) {
        unset($lines[$count]);
    }
    $count++;
}

file_put_contents($shadowfile, implode("", $lines));

redir("..");

?>
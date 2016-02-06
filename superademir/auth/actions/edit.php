<?php

include("../../../extras/funcs.php");
include("../authfunctions.php");
require_login("borginhos");

$user = req_post("user");
$pass = req_post("newpass");

$shadowfile = "../.shadow";

$newshadow = makeshadow($user, $pass) . "\n";

$lines = file($shadowfile);
$count = 0;
foreach ($lines as $line) {
    list($rightuser, $hashed, $salt) = explode("§", $line);
    if ($user == $rightuser) {
        $lines[$count] = $newshadow;
        break;
    }
    $count++;
}

file_put_contents($shadowfile, implode("", $lines));

redir("..");

?>
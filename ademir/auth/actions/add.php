<?php

#require_login("borginhos");
include("../../../extras/funcs.php");
include("../authfunctions.php");

$user = req_post("user");
$pass = req_post("pass");

$shadowfile = "../.shadow";

$shadow = makeshadow($user, $pass) . "\n";

file_put_contents($shadowfile, $shadow, FILE_APPEND);

redir("..");

?>
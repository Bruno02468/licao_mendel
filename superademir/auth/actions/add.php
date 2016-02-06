<?php

include("../../../extras/funcs.php");
include("../authfunctions.php");
require_login("borginhos");

$user = req_post("user");
$pass = req_post("pass");

$shadowfile = "../.shadow";

$shadow = makeshadow($user, $pass) . "\n";

file_put_contents($shadowfile, $shadow, FILE_APPEND);

redir("..");

?>
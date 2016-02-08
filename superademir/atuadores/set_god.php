<?php

include("../../extras/database.php");
require_login("borginhos");


$pass = htmlspecialchars_decode(req_post("pass"));
$salt = make_salt();
$opaque = hash("sha512", "${pass}${salt}");

file_put_contents("../../extras/.supershadow", "$opaque\n$salt");

redir("../");

?>

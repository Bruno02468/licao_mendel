<?php

include("../../extras/funcs.php");
include("../auth/authfunctions.php");
require_login("borginhos");

$id = req_post("id");

$dir = "../../salas/$id";
mkdir($dir);
file_put_contents($dir . "/.qc", "0");

redir("../salas.php");

?>
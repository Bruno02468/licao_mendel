<?php

include("../auth/authfunctions.php");
require_login("borginhos");
include("../../extras/funcs.php");

$id = req_post("id");

if (strlen($id) !== 2) die("PARA DE TROLHAR");
if ($id[0] == ".") die("AFF");

$dir = "../../salas/$id";
mkdir($dir);
file_put_contents($dir . "/.qc", "0");

redir("../salas.php");

?>
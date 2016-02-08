<?php

include("../../extras/database.php");
require_login("borginhos");

$id = req_post("id");

if (salaExists($id)) die("Sala já existe!");

$ademir = req_post("ademir");
$senha = req_post("pass");
$sal = make_salt();
$opaque = hash("sha512", "${senha}${sal}");

addSala($id, $opaque, $sal, $ademir);

redir("..");

?>
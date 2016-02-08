<?php

include("../../extras/database.php");
require_login("borginhos");

$id = req_post("id");
if (!salaExists($id)) die("Sala não existe!");

$ademir = req_post("ademir");
$senha = req_post("pass");
$sal = make_salt();
$opaque = hash("sha512", "${senha}${sal}");

setProperty($id, "opaque", $opaque);
setProperty($id, "salt", $sal);
setProperty($id, "ademir", $ademir);

redir("..");

?>
<?php

include("../../extras/funcs.php");
include("../auth/authfunctions.php");
require_login("borginhos");

$id = req_post("id");

mkdir("../../salas/$id");

redir("../salas.php");

?>
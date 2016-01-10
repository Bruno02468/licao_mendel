<?php

include("../auth/authfunctions.php");
require_login();
$sala = $_SERVER["PHP_AUTH_USER"];

unlink("../hors/$sala.horario");

redir("..")

?>
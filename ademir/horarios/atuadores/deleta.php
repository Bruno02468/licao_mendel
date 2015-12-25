<?php

include("../../../extras/funcs.php");

$sala = req_get("sala");

unlink("../hors/$sala.horario");

redir("..")

?>
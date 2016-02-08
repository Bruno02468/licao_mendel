<?php

include("../../extras/database.php");
require_login();
$sala = getUser();

setProperty($sala, "horario", array());
redir("..");

?>
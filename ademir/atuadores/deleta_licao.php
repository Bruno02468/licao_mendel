<?php

include("../../extras/database.php");
require_login();
$sala = getUser();
$guid = req_get("guid");

removeLicao($sala, $guid);

redir("../lista_licoes.php");

?>
<?php

include("../../extras/database.php");
require_login();
$sala = getUser();
$id = req_get("id");

removeLicao($sala, $id);

redir("../lista_licoes.php");

?>
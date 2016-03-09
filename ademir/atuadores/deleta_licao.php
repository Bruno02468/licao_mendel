<?php

include("../../extras/database.php");
require_login();
$sala = getUser();
$guid = req_get("guid");

removeLicao($sala, $guid);

if (isset($_GET["admvisao"])) {
    redir("../../sala/$sala");
} else {
    redir("../lista_licoes.php");
}

?>
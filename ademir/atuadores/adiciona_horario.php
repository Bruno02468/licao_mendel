<?php

include("../../extras/database.php");
require_login();
$sala = getUser();

$dias = array("segunda", "terça", "quarta", "quinta", "sexta");

$arr = array();
for ($i = 1; $i <= 8; $i++) {
    foreach ($dias as $dia) {
        array_push($arr, req_post("${dia}_$i"));
    }
}

setProperty($sala, "horario", $arr);

redir("..");
?>
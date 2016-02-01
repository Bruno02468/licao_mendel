<?php

include("../../../extras/funcs.php");
include("../../auth/authfunctions.php");
require_login();
$sala = $_SERVER["PHP_AUTH_USER"];

$dias = array("segunda", "terça", "quarta", "quinta", "sexta");

$arq = "";
for ($i = 1; $i <= 8; $i++) {
    foreach ($dias as $dia) {
        $arq .= req_post("${dia}_$i") . ";" . "\n";
    }
}
$arq = trim($arq);

file_put_contents("../hors/$sala.horario", $arq);
redir("..");
?>
<?php

include("../../../extras/funcs.php");

$sala = req_post("sala");
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
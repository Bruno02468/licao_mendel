<?php

include("../../extras/database.php");
require_login();
$sala = getUser();

$guid = req_post("guid");
$materia = req_post("materia");
$prova = isset($_POST["prova"]) ? true : false;
list($ano, $mes, $dia) = explode("-", req_post("calendario"));
$para = array(
    "dia" => $dia,
    "mes" => $mes,
    "ano" => $ano
);
$info = req_post("info");

editLicao($sala, $guid, $materia, $prova, $para, $info);

if (isset($_POST["admvisao"])) {
    redir("../../sala/$sala");
} else {
    redir("../lista_licoes.php");
}

?>
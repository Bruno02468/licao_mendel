<?php

include("../../extras/database.php");
require_login();
$sala = getUser();

$materia = req_post("materia");
$prova = isset($_POST["prova"]) ? true : false;
list($ano, $mes, $dia) = explode("-", req_post("calendario"));
$para = array(
    "dia" => $dia,
    "mes" => $mes,
    "ano" => $ano
);
$info = req_post("info");

addLicao($sala, $materia, $prova, $para, $info);

redir("../adicionar_licao.php");

?>
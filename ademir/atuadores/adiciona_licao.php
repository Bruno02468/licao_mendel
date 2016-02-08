<?php

include("../../extras/database.php");
require_login();
$sala = getUser();

$materia = req_post("materia");
$prova = isset($_POST["prova"]) ? true : false;
$para = array(
    "dia" => req_post("dia"),
    "mes" => req_post("mes"),
    "ano" => req_post("ano")
);
$info = req_post("info");

addLicao($sala, $materia, $prova, $para, $info);

redir("../adicionar_licao.php");

?>
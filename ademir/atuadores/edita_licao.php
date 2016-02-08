<?php

include("../../extras/database.php");
require_login();
$sala = getUser();

$guid = req_post("guid");
$materia = req_post("materia");
$prova = isset($_POST["prova"]) ? true : false;
$para = array(
    "dia" => req_post("dia"),
    "mes" => req_post("mes"),
    "ano" => req_post("ano")
);
$info = req_post("info");

editLicao($sala, $guid, $materia, $prova, $para, $info);

redir("..");

?>
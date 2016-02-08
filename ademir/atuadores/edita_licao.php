<?php

include("../../extras/database.php");
require_login();
$sala = getUser();

$id = req_post("id");
$materia = req_post("materia");
$prova = isset($_POST["prova"]) ? true : false;
$para = array(
    "dia" => req_post("dia"),
    "mes" => req_post("mes"),
    "ano" => req_post("ano")
);
$info = req_post("info");

editLicao($sala, $id, $materia, $prova, $para, $info);

redir("..");

?>
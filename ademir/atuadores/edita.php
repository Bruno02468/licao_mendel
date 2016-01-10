<?php

include("../../extras/funcs.php");

include("../auth/authfunctions.php");
require_login();
$sala = $_SERVER["PHP_AUTH_USER"];

$id = req_get('id');
$dados = req_get('dados');

$arquivo = "../../salas/" . $sala . "/" . $id;

file_put_contents($arquivo, $dados);

redir("../");

?>
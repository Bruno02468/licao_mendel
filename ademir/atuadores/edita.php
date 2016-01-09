<?php

include("../../extras/funcs.php");

$sala = req_get('sala');
$id = req_get('id');
$dados = req_get('dados');

include("../auth/authfunctions.php");
require_login($sala);

$arquivo = "../../salas/" . $sala . "/" . $id;

file_put_contents($arquivo, $dados);

redir("../../");

?>
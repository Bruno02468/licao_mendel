<?php

include("../../extras/funcs.php");

$sala = req_get('sala');
$id = req_get('id');
$dados = req_get('dados');

$arquivo = "../../salas/" . $sala . "/" . $id;

file_put_contents($arquivo, $dados);

redir("../../");

?>
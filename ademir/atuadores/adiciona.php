<?php

include("../../extras/funcs.php");

$sala = $_SERVER["PHP_AUTH_USER"];
$materia = req_get('materia');
$data = req_get('data');
$dados = req_get('dados');

include("../auth/authfunctions.php");
require_login($sala);

function proximo_nome($sala) {
    $pasta = "../../salas/" . $sala . "/";
    $contador = $pasta . ".qc";
    $last = file_get_contents($contador);

    $resultado = $last + 1;
    file_put_contents($contador, $resultado);

    return $pasta . $resultado;
}

$arquivo = $materia . "\n" . $data . "\n" . $dados;
$filename = proximo_nome($sala);
file_put_contents($filename, $arquivo);

redir("../cadastra.php");

?>
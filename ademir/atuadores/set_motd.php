<?php

include("../../extras/funcs.php");

$dados = htmlspecialchars_decode(req_get('dados'));

$arquivo = "motd.txt";

file_put_contents($arquivo, $dados);

$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
header("Location: http://$host$uri/../../");

?>

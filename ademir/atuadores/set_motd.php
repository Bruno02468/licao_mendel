<?php

include("../../extras/funcs.php");

include("../auth/authfunctions.php");
require_login("borginhos");

$dados = htmlspecialchars_decode(req_post('dados'));
$arquivo = "motd.txt";
file_put_contents($arquivo, $dados);

$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
redir("../");

?>

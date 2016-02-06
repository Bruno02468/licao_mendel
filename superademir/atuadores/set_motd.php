<?php

include("../auth/authfunctions.php");
require_login("borginhos");

include("../../extras/funcs.php");

$dados = htmlspecialchars_decode(req_post("dados"));
$arquivo = "motd.txt";
file_put_contents($arquivo, $dados);

redir("../");

?>

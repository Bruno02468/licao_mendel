<?php

include("../auth/authfunctions.php");
require_login("borginhos");

include("../../extras/funcs.php");

$dados = htmlspecialchars_decode(req_post("lista"));
$arquivo = "ademires.txt";
file_put_contents($arquivo, $dados);

jsredir("../");

?>

<?php

include("../../extras/database.php");
require_login("borginhos");


$dados = htmlspecialchars_decode(req_post("motd"));
$arquivo = "motd.txt";
file_put_contents($arquivo, $dados);

redir("../");

?>

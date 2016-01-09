<?php

include("../../extras/funcs.php");

$sala = htmlspecialchars(req_get('sala'));
$id = htmlspecialchars(req_get('id'));

include("../auth/authfunctions.php");
require_login($sala);

$arquivo = "../../salas/" . $sala . "/" . $id;
unlink($arquivo);

if (isset($_GET["lista"])) {
    redir("../editar_lista.php?sala=$sala");
} else {
    redir("../../salas/$sala");
}

?>
<?php

$sala = htmlspecialchars(req('sala'));
$id = htmlspecialchars(req('id'));

function req($str) {
    if (!isset($_GET[$str])) {
        die("Variável GET \"" . $str . "\" necessária para esta requisição.");
    } else {
        return $_GET[$str];
    }
}

$arquivo = "../../salas/" . $sala . "/" . $id;
unlink($arquivo);

$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
header("Location: http://$host$uri/../../salas/$sala");

?>
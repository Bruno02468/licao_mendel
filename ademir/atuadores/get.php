<?php

include("../../extras/funcs.php");

$sala = htmlspecialchars(req_get('sala'));

$arquivos = glob("../../salas/" . $sala . "/*");
foreach ($arquivos as $file) {
    $file = basename($file);
    if ('.' === $file) continue;
    if ('..' === $file) continue;
    if ('.qc' === $file) continue;
    if ('index.php' === $file) continue;
    echo $file . "#";
}

?>
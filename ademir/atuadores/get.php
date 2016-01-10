<?php

include("../../extras/funcs.php");

$sala = htmlspecialchars(req_get('sala'));

$arquivos = glob("../../salas/" . $sala . "/*");
foreach ($arquivos as $file) {
    $file = basename($file);
    if ($file[0] == ".") continue;
    echo $file . "#";
}

?>
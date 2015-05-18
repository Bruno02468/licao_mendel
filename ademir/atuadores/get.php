<?php

$sala = htmlspecialchars(req('sala'));

function req($str) {
    if (!isset($_GET[$str])) {
        die("Variável GET \"" . $str . "\" necessária para esta requisição.");
    } else {
        return $_GET[$str];
    }
}

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
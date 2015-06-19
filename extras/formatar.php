<?php
// Este arquivo pré-processa as lições antes de mostrá-las.
// Escrito por Bruno Borges Paschoalinoto.

function formatar($texto) {
    $linkreg = "/\[(.+)\|(.+)\]/";
    $linkrep = "<a href='$1'>$2</a>";
    $nlinkreg = "/\{(.+)\|(.+)\}/";
    $nlinkrep = "<a target='_blank' href='$1'>$2</a>";
    $nbspreg = "/^ +/";
    $nbsprep = "&nbsp;";

    $texto = htmlspecialchars($texto);
    $texto = preg_replace($linkreg, $linkrep, $texto);
    $texto = preg_replace($nlinkreg, $nlinkrep, $texto);
    $texto = preg_replace($nbspreg, $nbsprep, $texto);
    
    return $texto;
}

function formatar_array($arr) {
    $res = "";
    foreach ($arr as $key => $line) {
        $res .= formatar($line) . ($key <= count($arr) ? "<br>" : "");
    }
    return $res;
}

?>

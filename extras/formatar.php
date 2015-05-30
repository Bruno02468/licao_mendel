<?php
// Este arquivo pré-processa as lições antes de mostrá-las.
// Escrito por Bruno Borges Paschoalinoto.

function formatar($texto) {
    $linkreg = "/\[(.+)\|(.+)\]/";
    $linkrep = "<a href='$1'>$2</a>";
    $nlinkreg = "/\{(.+)\|(.+)\}/";
    $nlinkrep = "<a target='_blank' href='$1'>$2</a>";
    
    $texto = preg_replace($linkreg, $linkrep, $texto);
    $texto = preg_replace($nlinkreg, $nlinkrep, $texto);
    
    return $texto;
}

?>

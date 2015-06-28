<?php
// Este arquivo pré-processa as lições antes de mostrá-las.
// Escrito por Bruno Borges Paschoalinoto.

function formatar_array($arr) {
    $res = "";
    foreach ($arr as $key => $line)
        $res .= formatar($line) . ($key <= count($arr) ? "<br>" : "");
    return $res;
}
function substituir_global($padrao, $subst, $texto) {
    while (preg_match($padrao, $texto))
        $texto = preg_replace($padrao, $subst, $texto);
    return $texto;
}

function formatar($texto) {
    $not_bracket = "[^\]]";
    $linkreg = "/\[($not_bracket+)\|($not_bracket+)\]/";
    $linkrep = "<a target='_blank' href='$1'>$2</a>";
    $nbspreg = "/^ +/";
    $nbsprep = "&nbsp;";
    $imgreg = "/\[imagem:($not_bracket+)\]/";
    $imgrep = "<a target='_blank' title='Clique para ver o tamanho completo.' href='$1'><img src='$1'></a>";
    $bireg = "/\[(\/[biu]|[biu])\]/";
    $birep = "<$1>";
    $h4reg = "/\[big\]/";
    $h4rep = "<div class='big'>";
    $hcreg = "/\[\/big\]/";
    $hcrep = "</div>";
    $colorreg = "/\[cor:($not_bracket+)\]/";
    $colorrep = "<span style='color: $1;'>";
    $endcolorreg = "/\[\/cor\]/";
    $endcolorrep = "</span>";



    $texto = htmlspecialchars($texto);
    $texto = substituir_global($linkreg, $linkrep, $texto);
    $texto = substituir_global($nbspreg, $nbsprep, $texto);
    $texto = substituir_global($imgreg, $imgrep, $texto);
    $texto = substituir_global($bireg, $birep, $texto);
    $texto = substituir_global($h4reg, $h4rep, $texto);
    $texto = substituir_global($hcreg, $hcrep, $texto);
    $texto = substituir_global($colorreg, $colorrep, $texto);
    $texto = substituir_global($endcolorreg, $endcolorrep, $texto);

    return $texto;
}

?>

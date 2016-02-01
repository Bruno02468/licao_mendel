<?php

include("funcs.php");

function maketd($s) {
    $res = "<td";
    if ($s === "")
        $res .= " class=\"horgray\"";
    else
        $res .= " class=\"horgreen\"";
    $res .= ">$s</td>";
    return $res;
}

$sala = req_get("sala");
$arq = file("../ademir/horarios/hors/$sala.horario");
$others = "";
$intervalo = "<tr class=\"horgray\"><td><b>Intervalo</b></td><td><b>Intervalo</b></td><td><b>Intervalo</b></td><td><b>Intervalo</b></td><td><b>Intervalo</b></td><td><b>Intervalo</b></td></tr>";

for ($aula = 1; $aula <= 8; $aula++) {
    $others .= "<tr><td class=\"hororange\">${aula}ª Aula</td>";
    for ($dia = 0; $dia <= 4; $dia++) {
        $mat = substituir_global("/;/", "", trim($arq[($aula-1)*5 + $dia]));
        $others .= maketd($mat);
    }
    $others .= "</tr>";
    if ($aula == 3 || $aula == 5)
        $others .= $intervalo;
    $others .= "\n";
}

?>

<link rel="stylesheet" href="estilo.css">
<table class="horario">
    <tr class="hordias">
        <td>&nbsp;&nbsp;&nbsp;Aula/Dia&nbsp;&nbsp;&nbsp;</td><td>Segunda</td><td>Terça</td><td>Quarta</td><td>Quinta</td><td>Sexta</td>
    </tr>
    <?php echo $others; ?>
</table>

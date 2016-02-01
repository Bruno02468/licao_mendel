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

function intervalo($n) {
    $time = ["9:20", "11:15"][$n-1];
    return "<tr class=\"horgray\"></td><td><b>${n}º Intervalo ($time)</b></td><td><b>Intervalo</b></td><td><b>Intervalo</b></td><td><b>Intervalo</b></td><td><b>Intervalo</b></td><td><b>Intervalo</b></td></tr>";
}



for ($aula = 1; $aula <= 8; $aula++) {
    $aulatimes = ["7:05", "7:50", "8:35", "9:45", "10:30", "11:40", "12:25", "13:10"];
    $time = $aulatimes[$aula-1];
    $others .= "<tr><td class=\"hororange\">${aula}ª Aula ($time)</td>";
    for ($dia = 0; $dia <= 4; $dia++) {
        $mat = substituir_global("/;/", "", trim($arq[($aula-1)*5 + $dia]));
        $others .= maketd($mat);
    }
    $others .= "</tr>";
    if ($aula == 3 || $aula == 5)
        $others .= intervalo(floor($aula / 2));
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

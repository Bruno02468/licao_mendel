<?php

function maketd($s) {
    $res = "<td";
    if ($s === "")
        $res .= " class=\"horgray\"";
    else
        $res .= " class=\"horgreen\"";
    $res .= ">$s</td>";
    return $res;
}


function intervalo($n) {
    $time = ["9:20", "11:15"][$n-1];
    return "<tr class=\"horgray\"></td><td><b>Intervalo ($time)</b></td>
    <td><b>Intervalo</b></td><td><b>Intervalo</b></td><td><b>Intervalo</b></td>
    <td><b>Intervalo</b></td><td><b>Intervalo</b></td></tr>";
}

function getHorario($sala) {
    $arr = getProperty($sala, "horario");
    $others = "";
    $aulatimes = ["7:05", "7:50", "8:35", "9:45", "10:30", "11:40", "12:25", "13:10"];
    for ($aula = 1; $aula <= 8; $aula++) {
        $time = $aulatimes[$aula-1];
        $others .= "<tr><td class=\"hororange\">${aula}ª Aula ($time)</td>";
        for ($dia = 0; $dia <= 4; $dia++) {
            $mat = $arr[($aula-1)*5 + $dia];
            $others .= maketd($mat);
        }
        $others .= "</tr>";
        if ($aula == 3 || $aula == 5)
            $others .= intervalo(floor($aula / 2));
        $others .= "\n";
    }
    return "
    <table class=\"horario\">
        <tr class=\"hordias\">
            <td>&nbsp;&nbsp;&nbsp;Aula/Dia&nbsp;&nbsp;&nbsp;</td><td>Segunda</td>
            <td>Terça</td><td>Quarta</td><td>Quinta</td><td>Sexta</td>
        </tr>
        $others
    </table>";
}

function getHorarioAdder($sala) {
    $arr = getProperty($sala, "horario");

    $dia = new DateTime();
    $weekdays = array(
        "Monday" => "",
        "Tuesday" => "",
        "Wednesday" => "",
        "Thursday" => "",
        "Friday" => ""
    );
    for ($add = 0; $add <= 20; $add++) {
        if ($add > 0) $dia->add(new DateInterval("P1D"));
        $semana = $dia->format("l");
        if ($semana !== "Saturday" && $semana !== "Sunday") {
            $disp = $dia->format("j/n");
            $link = "<a class=\"dialink\" href=\"javascript:void(0)\" onclick=\"setData('$disp')\">$disp</a>";
            $weekdays[$semana] .= $link;
            if ($add < 14) $weekdays[$semana] .= ", ";
        }
    }

    $others = "";
    for ($aula = 1; $aula <= 8; $aula++) {
        for ($dia = 0; $dia <= 4; $dia++) {
            $mat = $arr[($aula-1)*5 + $dia];
            $others .= maketd($mat);
        }
        $others .= "</tr>";
        $others .= "\n";
    }
    return "
    <table class=\"horario adder\">
        <tr class=\"hordias\">
            <td>Segunda<br>(" . $weekdays["Monday"] . ")</td>
            <td>Terça<br>(" . $weekdays["Tuesday"] . ")</td>
            <td>Quarta<br>(" . $weekdays["Wednesday"] . ")</td>
            <td>Quinta<br>(" . $weekdays["Thursday"] . ")</td>
            <td>Sexta<br>(" . $weekdays["Friday"] . ")</td>
        </tr>
        $others
    </table><br>";
}

?>

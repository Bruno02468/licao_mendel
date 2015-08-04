<?php
/* Página inicial para o site de lições.
 * Escrito pelo Bruno Borges Paschoalinoto.
 * Altas programações :-)
 */
date_default_timezone_set("America/Sao_Paulo");

include("extras/formatar.php");

function asemana($dia) {
    switch ($dia) {
        case "Sunday":
            return "domingo";
        case "Monday":
            return "segunda";
        case "Tuesday":
            return "terça";
        case "Wednesday":
            return "quarta";
        case "Thursday":
            return "quinta";
        case "Friday":
            return "sexta";
        case "Saturday":
            return "sábado";
        default:
            return "<b>erro de dia da semana, wtf</b>";
    }
}

function semana($dia) { return "<b>" . asemana($dia) . "</b>"; }

$sala = "1E";
if (isset($_GET['sala'])) {
    $sala = $_GET['sala'];
}

$nome = $sala[0] . "º " . $sala[1];
$pasta = "salas/" . $sala . "/";
if (!file_exists($pasta) && isset($_GET['sala'])) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/licao");
    die();
}

$formato = "Y/m/d";
$hoje = date($formato, time());
$hoje_semana = semana(date("l", time()));
$amanha = date($formato, strtotime('+1 day', strtotime($hoje)));
$dois = date($formato, strtotime('+2 day', strtotime($hoje)));
$tres= date($formato, strtotime('+3 day', strtotime($hoje)));
$ontem = date($formato, strtotime('-1 day', strtotime($hoje)));
$hojes = "";
$amanhas = "";
$outras = "";
$segundas_span = "<span class='importante'>Lições para segunda:</span><br><br>";
$segundas = "";

$arquivos = glob($pasta . "*");
usort($arquivos, function($a, $b) {
    $entrega_a = strtotime(file($a)[1]);
    $entrega_b = strtotime(file($b)[1]);
    return $entrega_b < $entrega_a;
});

foreach ($arquivos as $full) {
    $file = basename($full);
    if ('.' === $file) continue;
    if ('..' === $file) continue;
    if ('.qc' === $file) continue;
    if ('index.php' === $file) continue;
    if ('get.php' === $file) continue;


    $arquivo = file($pasta . $file);

    $mat = formatar(trim($arquivo[0]));
    $v = "fez";
    $ent = "de entrega";
    $gabaritei = "Gabaritei";
    $classe = "";

    if (strpos($mat, "PROVA - ") !== false) {
        $mat = str_replace("PROVA - ", "", $mat);
        $v = "estudou";
        $ent = "da prova";
        $gabaritei = "Estou careca de estudar";
        $classe = " class='prova'";
    }

    $final = "<acronym title='ID de lição: " . $file . "'><table$classe>\n";

    $materia = "<tr><td valign='top'><span class='semiimportante'>Matéria:</span> </td><td valign='top'>$mat<br></td></tr>\n";
    $datastr = $arquivo[1];
    $entrega_time = strtotime($datastr);
    $entrega = date($formato, $entrega_time);

    if ($entrega_time < strtotime($hoje)) {
        unlink($pasta . $file);
        continue;
    }

    $datafin = date("d/m/Y", $entrega_time);
    $semanal = semana(date("l", $entrega_time));
    $datapre = "<tr><td valign='top'><span class='semiimportante'>Data $ent:</span> </td><td valign='top'>$datafin ($semanal)<br></td></tr>\n";

    $dadosarr = $arquivo;
    unset($dadosarr[0]);
    unset($dadosarr[1]);
    $dados = "<tr><td valign='top'><span class='semiimportante'>Informações:</span> </td><td valign='top'>" . formatar_array($dadosarr) . "<br></td></tr>\n";

    $check = "<tr><td valign='top'><span class='semiimportante'>Já $v?</span> </td><td valign='top'><input type='checkbox' id='$file' onclick='toggleFeita(this.id)'>$gabaritei<br></td></tr>\n";
    $final .= $materia;
    $final_sem_data = $final . $dados . $check . "</table></acronym><br>\n";
    $final_com_data = $final . $datapre . $dados. $check . "</table></acronym><br>\n";

    if ($entrega == $hoje) {
        $hojes .= $final_sem_data;
    } else if ($entrega == $amanha) {
        $amanhas .= $final_sem_data;
    } else if (($hoje_semana == "sexta" || $hoje_semana == "sábado") && $semanal == "segunda" && ($entrega == $dois || $entrega == $tres)) {
        $segundas .= $final_sem_data;
    } else {
        $outras .= $final_com_data;
    }

}

if ($hojes == "") {
    $hojes = "<i>Sem lição para hoje, descanse.<br><br></i>\n";
}
if ($amanhas == "") {
    $amanhas = "<i>Oba! Sem lição para amanhã! Mas não se esqueça de fazer as outras!</i><br><br>\n";
}
if ($outras == "") {
    $outras = "<i>Sem outras lições, legal!</i>\n";
}
if ($segundas == "") {
    $segundas = "<i>Sem lição para segunda, boa!<br><br></i>\n";
}

?>
<?php include("extras/top.php") ?>
<br>
<br>
<span class="importante">Lições para hoje:</span><br><br>
<?php echo $hojes; ?>
<hr>
<br>
<span class="importante">Lições para amanhã:</span><br><br>
<?php echo $amanhas; ?>
<hr>
<br>
<?php
    if ($hoje_semana == "sexta" || $hoje_semana == "sábado") {
        echo "<span class='importante'>Lições para segunda:</span><br><br>$segundas</table></acronym><hr><br>\n";
    }
?>
<span class="importante">Lições para outros dias:</span><br><br>
<?php echo $outras; ?>

<script type="text/javascript" src="extras/javascript.js"></script>
<br>

</body>
</html>
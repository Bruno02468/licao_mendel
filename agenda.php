<?php

include("extras/funcs.php");

date_default_timezone_set("America/Sao_Paulo");

$sala = "1E";
if (isset($_GET['sala'])) {
    $sala = $_GET['sala'];
}

$nome = $sala[0] . "º " . $sala[1];
$pasta = "salas/" . $sala . "/";
if (!file_exists($pasta)) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/licao");
    die();
}

$hojes = "";
$outras = "";
$hoje = date("d/m/Y");
$amanha = strtotime('+1 day', time());

$arquivos = glob($pasta . "*");
usort($arquivos, function($a, $b) {
    return filectime($a) < filectime($b);
});

foreach ($arquivos as $file) {
    if ('.' === $file) continue;
    if ('..' === $file) continue;
    if ('.qc' === $file) continue;
    if ($pasta . 'index.php' === $file) continue;
    if ($pasta . 'get.php' === $file) continue;

    $arquivo = file($file);

    $mat = formatar(trim($arquivo[0]));
    $v = "fez";
    $ent = "de entrega";
    $gabaritei = "Gabaritei";
    $classe = "entrada";

    if (strpos($mat, "PROVA - ") !== false) {
        $mat = str_replace("PROVA - ", "", $mat);
        $v = "estudou";
        $ent = "da prova";
        $gabaritei = "Estou careca de estudar";
        $classe .= " prova";
    }

    $final = "<acronym title='ID de lição: " . $file . "'><table class='$classe'>\n";

    $datacri = filectime($file);
    $pass = date("d/m/Y", $datacri);
    $materia = "<tr><td valign='top' class='notop'><span class='semiimportante'>Matéria:</span> </td><td class='notop' valign='top'>$mat<br></td></tr>\n";
    $passada = "<tr><td valign='top'><span class='semiimportante'>Passada em:</span> </td><td valign='top'>$pass<br></td></tr>";
    $datastr = $arquivo[1];
    $entrega = strtotime($datastr);

    $datafin = date("d/m/Y", $entrega);
    $semanal = semana(date("l", $entrega));
    if (date("d/m/Y", $amanha) == $datafin) {
        $semanal = "<b>amanhã</b>";
    }

    $datapre = "<tr><td valign='top'><span class='semiimportante'>Data $ent:</span> </td><td valign='top'>$datafin ($semanal)<br></td></tr>\n";

    $dadosarr = $arquivo;
    unset($dadosarr[0]);
    unset($dadosarr[1]);
    $dados = "<tr><td valign='top'><span class='semiimportante'>Informações:</span> </td><td valign='top'>" . formatar_array($dadosarr) . "<br></td></tr>\n";
    $final .= $materia;

    $check = "<tr><td valign='top'><span class='semiimportante'>Já $v?</span> </td><td valign='top'><input type='checkbox' id='" . basename($file) . "' onclick='toggleFeita(this.id)'>$gabaritei<br></td></tr>\n";
    if ($pass == $hoje) {
        $final .= $datapre . $dados. $check . "</table></acronym><br><br>\n";
        $hojes .= $final;
    } else {
        $final .= $passada . $datapre . $dados . $check . "</table></acronym><br><br>\n";
        $outras .= $final;
    }

}

if ($hojes == "") {
    $hojes = "<i>Nenhuma lição foi passada hoje.</i><br><br>\n";
}
if ($outras == "") {
    $outras = "<i>Nenhuma lição foi passada em outros dias...</i>\n";
}

?>
<?php include("extras/top.php"); ?>
<br>
<br>
<span class="importante">Lições passadas hoje:</span><br><br>
<?php echo $hojes; ?>
<hr>
<span class="importante">Lições passadas em outros dias:</span><br><br>
<?php echo $outras; ?>
<br>
<script src="extras/javascript.js"></script>
</body>
</html>
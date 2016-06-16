<?php

// Inclui o arquivo com as funções compartilhadas.
include("extras/database.php");
include("extras/horario2html.php");

// Usar a minha sala como padrão, a não ser que outra seja especificada.
$sala = "";
if (isset($_GET["sala"])) {
    $sala = $_GET["sala"];
}

if ($sala == "") {
    redir(".");
    die();
}

// Nome da sala.
$nome = nomeSala($sala);

// Checagem para ver se a sala existe, e, caso contrário, voltar à página inicial.
if (!salaExists($sala) && isset($_GET["sala"]) && $sala !== "") {
    redir(".");
    die();
}

$horario = "";
if (hasHorario($sala)) {
    $conts = getHorario($sala);
    $horario = "<br><a class=\"buttonlink\" id=\"horlink\" href=\"javascript:void(0)\" onclick=\"horario();\">Ver horário de aulas</a><br>\n
    <span id=\"hor\">$conts</span>";
}

$msg = "<div id=\"msgadm\" class=\"admvisao\"><br>
    <a class=\"buttonlink smallbtn\" href=\"../ademir/reqsala.php?sala=$sala&ir=editar_msg.php?admvisao\">Adicionar uma mensagem da sala</a><br><br></div>";
if (hasMsg($sala)) {
    $conteudo = formatar(getProperty($sala, "msg"));
    $msg = "<br>
    Mensagem da sala: <div id=\"msgadm\" class=\"admvisao\"><a class=\"buttonlink smallbtn\" href=\"../ademir/reqsala.php?sala=$sala&ir=editar_msg.php?admvisao\">editar</a>
    <a class=\"buttonlink smallbtn\" href=\"../ademir/reqsala.php?sala=$sala&ir=atuadores%2Fdeleta_msg.php?admvisao\">deletar</a></div><br>
    <small><div class=\"mensagem\">$conteudo</div></small><br>";
}

$licoes = getProperty($sala, "licoes");

// Variável para guardar o HTML
$final = "";

// Ordenar a array de acordo
usort($licoes, function($a, $b) {
    if (!isset($a["guid"]) || !isset($b["guid"])) return false;
    return dataToTime($b["para"]) < dataToTime($a["para"]);
});

function make_div($a, $c="") {
    return "<div class=\"entradiv$c\">$a</div>";
}


$hoje_semana = semana(date("l", time()));
$hoje_data = timeToData(time());
$hoje_timestamp = dataToTime($hoje_data);
$amanha_data = addDias($hoje_data, 1);
$dois = addDias($hoje_data, 2);
$tres = addDias($hoje_data, 3);
$sextaousabado = ($hoje_semana == "sexta" || $hoje_semana == "sábado");

// Gerar o HTML das lições
foreach ($licoes as $id => $licao) {
    if (!isset($licao["guid"])) continue;
    if (isset($licao["removed"])) if ($licao["removed"]) continue;

    $passada_timestamp = dataToTime($licao["passada"]);
    $entrega_timestamp = dataToTime($licao["para"]);
    if ($entrega_timestamp < $hoje_timestamp) continue;

    $guid = $licao["guid"];
    $semanal = semana(date("l", $entrega_timestamp));
    $passadahj = ($licao["passada"] == $hoje_data);

    $proxima = $licao["para"] == $amanha_data
        || ($semanal == "segunda" && $sextaousabado &&
        ($licao["para"] == $dois || $licao["para"] == $tres));
    $perto = ($semanal == "segunda") ? "<b>segunda</b>" : "<b>amanhã</b>";
    $parahj = ($licao["para"] == $hoje_data);

    $display = ($parahj ? " style=\"display: 'none'\"" : "");
    $classes = ($passadahj ? " hoje" : "") . ($licao["prova"] ? " prova" : "") . ($parahj ? " parahj" : "") . ($proxima ? " proxima" : "");

    $editlink = "<a class=\"buttonlink smallbtn\" href=\"../ademir/reqsala.php?sala=$sala&ir=editar_licao.php%3Fguid%3D$guid%26admvisao\">editar</a>";
    $deletelink = "<a class=\"buttonlink btnred smallbtn\" href=\"javascript:void(0);\" onclick=\"deletar('$guid')\">deletar</a>";

    $tabela = "<div class=\"entrada$classes\"$display>\n";

    $tabela .= make_div(formatar($licao["materia"]))
        . make_div(formatar_array(explode("\n", $licao["info"])), " infos")
        . make_div("Para " . ($proxima ? "$perto" : ($parahj ? "hoje" : ("o dia " . date("d/m", dataToTime($licao["para"])) . " ($semanal)"))), " datas")
        . make_div("<label class=\"checklabel\"><input type=\"checkbox\" id=\"$guid\" onclick=\"toggleFeita(''+this.id)\">Marcar como feita</label>")
        . "<div class=\"entradiv admvisao\">$editlink ou $deletelink</div>";


    $tabela .= "</div><br>";
    $final .= $tabela;
}

if ($final == "")
    $final = "Nenhuma lição por enquanto...";

?>
<html>
    <head>
        <title>Lições do <?php echo $nome; ?></title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body>
        <?php include_once("extras/ga.php"); ?>
        <h1>Lições do <?php echo $nome; ?></h1>
        <a class="buttonlink btnorange smallbtn" href="//licoes.com/resumos">Resumos</a><br><br>
        <a class="buttonlink" href="javascript:void(0)" onclick="escolherSala()">Voltar para a lista de salas</a><br>
        <?php echo $horario; ?>
        <br>
            <small>
                <a class="buttonlink btnblue" href="../ademir/reqsala.php?sala=<?php echo $sala; ?>">Administrar esta sala</a><br>
                <br>
                <div class="admvisao" id="admwarn">
                    <a class="buttonlink" href="../ademir/reqsala.php?sala=<?php echo $sala; ?>&amp;ir=adicionar_licao.php">Adicionar lições</a><br><br>
                    <b>Os novos links de administrador estão ativos!<br>
                    <a href="javascript:void(0)" onclick="desadm()">Clique se quiser desligar, ou não for um administrador.</a></b><br>
                    <br>
                </div>
                Tudo programado por <a target="_blank" href="../contato.html">Bruno Borges Paschoalinoto</a> (2º F)<br><br>
                Mensagem global:<br>
                <div class="mensagem"><?php echo formatar(file_get_contents("superademir/atuadores/motd.txt")); ?>
            </div><br></small>
        <br>
        Esta sala é administrada por <b><?php echo getProperty($sala, "ademir"); ?></b>!<br>
        <?php echo $msg; ?>
        <span id="hojeslink"></span>
        <br>
        <br>
        <?php echo $final; ?>
        <script>
            sala = "<?php echo $sala; ?>";
            nome = "<?php echo $nome; ?>";
        </script>
        <script src="../extras/javascript.js"></script>
    </body>
</html>

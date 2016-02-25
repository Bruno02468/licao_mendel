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
    $horario = "<br><a id=\"horlink\" href=\"javascript:void(0)\" onclick=\"horario();\">[Ver horário de aulas]</a><br>\n
    <span id=\"hor\">$conts</span>";
}

$licoes = getProperty($sala, "licoes");

// Variável para guardar o HTML
$final = "";

// Ordenar a array de acordo
usort($licoes, function($a, $b) {
    return dataToTime($b["para"]) < dataToTime($a["para"]);
});

// Função para gerar os TRs
function make_tr($a, $b) {
    return "<tr><td>$a</td><td>$b</td></tr>\n";
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
    $guid = $licao["guid"];
    $passada_timestamp = dataToTime($licao["passada"]);
    $entrega_timestamp = dataToTime($licao["para"]);

    if ($entrega_timestamp < $hoje_timestamp) {
        continue;
    }
    if (isset($licao["removed"])) if ($licao["removed"]) continue;

    $semanal = semana(date("l", $entrega_timestamp));
    $passadahj = ($licao["passada"] == $hoje_data);

    $proxima = $licao["para"] == $amanha_data
        || ($semanal == "segunda" && $sextaousabado &&
        ($licao["para"] == $dois || $licao["para"] == $tres));
    $perto = ($semanal == "segunda") ? "<b>Segunda</b>" : "<b>Amanhã</b>";
    $parahj = ($licao["para"] == $hoje_data);

    $display = ($parahj ? " style=\"display: 'none'\"" : "");
    $classes = ($passadahj ? " hoje" : "") . ($licao["prova"] ? " prova" : "") . ($parahj ? " parahj" : "") . ($proxima ? " proxima" : "");

    $tabela = "<table class=\"entrada$classes\"$display>\n";

    $tabela .= make_tr("Matéria:", formatar($licao["materia"]))
        . make_tr("Informações:", formatar_array(explode("\n", $licao["info"])))
        . make_tr("Para:", ($proxima ? "<b>$perto</b>" : ($parahj ? "<b>Hoje</b>" : (date("d/m", dataToTime($licao["para"])) . " (<b>$semanal</b>)"))))
        . make_tr("Feita?", "<input type=\"checkbox\" id=\"$guid\" onclick=\"toggleFeita(''+this.id)\">Feita!");


    $tabela .= "</table>";
    $final .= $tabela;
}

if ($final == "")
    $final = "Nenhuma lição por enquanto...";

$adm = "Esta sala é administrada por <b>" . getProperty($sala, "ademir") . "</b>!";

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
        <h1>Site de lições do <?php echo $nome; ?></h1>
        <small>Tudo programado por <a target="_blank" href="../contato.html">Bruno Borges Paschoalinoto</a> (2º F)<br><br></small>
        <a href="javascript:void(0)" onclick="escolherSala()">[Escolha sua sala]</a><br>
        <?php echo $horario; ?>
        <br>
            <small><a href="../ademir">[Administrar o Site]</a><br><br>
            <small><a href="../superademir">[Superadministrar o Site]</a></small><br>
            <br>Mensagem do dia:<br>
            <div class="mensagem"><?php echo formatar(file_get_contents("superademir/atuadores/motd.txt")); ?>
            </div><br></small>
        <br>
        <?php echo $adm; ?><br>
        <span id="hojeslink"></span>
        <br>
        <br>
        <?php echo $final; ?>
        <script>
            sala = "<?php echo $sala; ?>";
            nome = "<?php echo $nome; ?>";
        </script>
        <script src="../extras/javascript.js"></script>
        <script>
            function escolherSala() {
                localStorage["sala"] = "";
                location.href = "..";
            }
        </script>
    </body>
</html>

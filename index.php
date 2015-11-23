<?php

// Inclui o arquivo com as funções compartilhadas.
include("extras/funcs.php");

// Usar a timezone daqui.
date_default_timezone_set("America/Sao_Paulo");

// Usar a minha sala como padrão, a não ser que outra seja especificada.
$sala = "1E";
if (isset($_GET["sala"])) {
    $sala = $_GET["sala"];
}

// Nome da sala.
$nome = $sala[0] . "º " . $sala[1];

// Pasta com os arquivos da sala.
$pasta = "salas/" . $sala . "/";

// Checagem para ver se a sala existe, e, caso contrário, voltar à página inicial.
if (!file_exists($pasta) && isset($_GET["sala"])) {
    redir("");
    die();
}

if (file_exists("horarios/$sala.png")) {

}

// Formato de data usado nos arquivos.
$formato = "Y/m/d";

// Formato de data mostrado aos usuários.
$formato_display = "d/m/Y";

// Classe para lições
class Licao {
    public $materia = "";
    public $info = "";
    public $entrega = "";
    public $criada = "";
    public $prova = "";
    public $id = "";
}

// Hoje
$hoje = date($formato, time());
$hoje_display = date($formato_display, time());
$hoje_semana = semana(date("l", time()));

// Data de amanhã.
$amanha = date($formato, strtotime("+1 day", strtotime($hoje)));

// Data de depois de amanhã.
$dois = date($formato, strtotime("+2 day", strtotime($hoje)));

// Data de depois de depois de amanhã.
$tres = date($formato, strtotime("+3 day", strtotime($hoje)));
// Data de ontem.
$ontem = strtotime("-1 day", strtotime($hoje));

$licoes = array();

$arquivos = glob($pasta . "*");
foreach ($arquivos as $full) {
    // Testar o nome base do arquivo para pular arquivos padrão.
    $file = basename($full);
    if ("." === $file) continue;
    if (".." === $file) continue;
    if (".qc" === $file) continue;

    // Array com as linhas do arquivo.
    $arquivo = file($full);

    $licao = new Licao();
    $licao->id = $file;

    // Ler a data de entrega do arquivo.
    $licao->entrega = trim($arquivo[1]);

    // Ler data numérica é apagar lições antigas, para preservar espaço.
    $entrega_time = strtotime($licao->entrega);
    if ($entrega_time < $ontem) {
        unlink($full);
        continue;
    }

    // Ver se é prova...
    $licao->prova = (strpos($arquivo[0], "PROVA - ") !== false);

    // A matéria a ser mostrada.
    $licao->materia = formatar(str_replace("PROVA - ", "", trim($arquivo[0])));

    // Ler as informações e formatá-las.
    unset($arquivo[0]);
    unset($arquivo[1]);
    $licao->info = formatar_array($arquivo);

    // Ler a data de criação.
    $licao->criada = filectime($full);

    // Adicionar nossa lição à array.
    array_push($licoes, $licao);

    // Próximo arquivo.
}

$final = "";
$ordenar = function($a, $b) {
    return strtotime($b->entrega) < strtotime($a->entrega);
};

if (isset($_GET["hoje"])) {
    $ordenar = function($a, $b) {
        return $b->criada < $a->criada;
    };
}

usort($licoes, $ordenar);

function make_tr($a, $b) {
    return "<tr><td>$a</td><td>$b</td></tr>\n";
}

foreach ($licoes as $licao) {
    $data_criada = date($formato_display, $licao->criada);
    $semanal = semana(date("l", strtotime($licao->entrega)));
    $hj = ($data_criada == $hoje_display);
    $proxima = $licao->entrega == $amanha
        || ($semanal == "segunda" && ($hoje_semana == "sexta" || $hoje_semana == "sábado")
            && ($licao->entrega == $dois || $licao->entrega == $tres));
    $perto = ($semanal == "segunda") ? "<b>Segunda</b>" : "<b>Amanhã</b>";
    $parahj = ($licao->entrega == $hoje);

    $tabela = "<table class=\"entrada" . ($hj ? " hoje" : "") . ($licao->prova ? " prova" : "") . ($parahj ? " parahj" : "") . ($proxima ? " proxima" : "") . "\">\n";

    $tabela .= make_tr("Matéria:", $licao->materia)
        . make_tr("Informações:", $licao->info)
        . ($hj ? "" : make_tr("Passada:", ($hj ? "<b>Hoje</b>" : $data_criada)))
        . make_tr("Para:", ($proxima ? "<b>$perto</b>" : ($parahj ? "<b>Hoje</b>" : ($licao->entrega . " (<b>$semanal</b>)"))))
        . make_tr("Ok?", "<input type=\"checkbox\" id=\"$licao->id\" onclick=\"toggleFeita(this.id)\">Ok!");


    $tabela .= "</table>";
    $final .= $tabela;
}

?>



<html>
    <head>
        <title>Lições do <?php echo $nome; ?></title>
        <link rel="stylesheet" href="extras/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta charset="UTF-8">
    </head>

    <body>
        <?php include_once("extras/ga.php"); ?>
        <h1>Site de lições do <?php echo $nome; ?></h1>
        <small>
            Tudo programado por <a target="_blank" href="contato.html">Bruno Borges Paschoalinoto</a> (1º E)<br>
            <small><small><a href="ademir/">[Somente pessoal autorizado]</a><br></small></small>
            <br>Mensagem do dia:<br>
            <div class="mensagem">
                <?php echo formatar_array(explode("\n", file_get_contents("ademir/atuadores/motd.txt"))); ?>
            </div>
        </small>
        <br>
        <br>
        <a onclick="killHoje(this)"><big>Esconder lições para hoje</big></button>
        <br>
        <br>
        <?php echo $final; ?>
        <script src="extras/javascript.js"></script>
    </body>
</html>

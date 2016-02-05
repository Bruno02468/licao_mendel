<?php

// Inclui o arquivo com as funções compartilhadas.
include("extras/funcs.php");

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
$nome = $sala[0] . "º " . $sala[1];

// Pasta com os arquivos da sala.
$pasta = "salas/" . $sala . "/";

// Checagem para ver se a sala existe, e, caso contrário, voltar à página inicial.
if (!file_exists($pasta) && isset($_GET["sala"]) && $sala !== "") {
    redir(".");
    die();
}

$horario = "";
if (file_exists("ademir/horarios/hors/$sala.horario")) {
    $horario = "<br><a href=\"javascript:void(0)\" onclick=\"horario();\">[Horário do $nome]</a><br>\n
    <span id=\"hor\"></span>";
}

// Formato de data usado nos arquivos.
$formato = "Y/n/j";

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

// Array para guardar as lições
$licoes = array();

// Preencher a array
foreach (glob($pasta . "*") as $full) {
    // Testar o nome base do arquivo para pular arquivos padrão.
    $file = basename($full);
    if ("." === $file[0]) continue;

    // Array com as linhas do arquivo.
    $arquivo = file($full);

    // Criar o objeto de lição
    $licao = new Licao();
    $licao->id = $file;

    // Ler a data de entrega do arquivo.
    $licao->entrega = trim($arquivo[1]);

    // Ler data numérica é apagar lições antigas, para preservar espaço.
    $entrega_time = strtotime($licao->entrega);
    if ($entrega_time <= $ontem) {
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

// Variável para guardar o HTML
$final = "";

// Ordenar a array de acordo

$link = "<a href=\"./$sala\">[Ver lições por data de criação]</a>";

$ordenar = function($a, $b) {
    return strtotime($b->entrega) < strtotime($a->entrega);
};

if (isset($_GET["recentes"])) {
    $ordenar = function($a, $b) {
        return $b->criada < $a->criada;
    };
    $link = "<a href=\".\">[Ver lições por data de entrega]</a>";
}

usort($licoes, $ordenar);

// Função para gerar os TRs
function make_tr($a, $b) {
    return "<tr><td>$a</td><td>$b</td></tr>\n";
}

// Gerar o HTML das lições
foreach ($licoes as $licao) {
    $data_criada = date($formato_display, $licao->criada);
    $semanal = semana(date("l", strtotime($licao->entrega)));
    $hj = ($data_criada == $hoje_display);
    $proxima = $licao->entrega == $amanha
        || ($semanal == "segunda" && ($hoje_semana == "sexta" || $hoje_semana == "sábado")
            && ($licao->entrega == $dois || $licao->entrega == $tres));
    $perto = ($semanal == "segunda") ? "<b>Segunda</b>" : "<b>Amanhã</b>";
    $parahj = ($licao->entrega == $hoje);

    $display = ($parahj ? " style=\"display: 'none'\"" : "");
    $classes = ($hj ? " hoje" : "") . ($licao->prova ? " prova" : "") . ($parahj ? " parahj" : "") . ($proxima ? " proxima" : "");

    $tabela = "<table class=\"entrada$classes\"$display>\n";

    $tabela .= make_tr("Matéria:", $licao->materia)
        . make_tr("Informações:", $licao->info)
        . (isset($_GET["hoje"]) ? make_tr("Passada:", ($hj ? "<b>Hoje</b>" : "$data_criada (<b>$semanal<b>)")) : "")
        . make_tr("Para:", ($proxima ? "<b>$perto</b>" : ($parahj ? "<b>Hoje</b>" : (date($formato_display, strtotime($licao->entrega)) . " (<b>$semanal</b>)"))))
        . make_tr("Ok?", "<input type=\"checkbox\" id=\"$licao->id\" onclick=\"toggleFeita(this.id)\">Ok!");


    $tabela .= "</table>";
    $final .= $tabela;
}

if ($final == "")
    $final = "Nenhuma lição por enquanto...";

$ademires_file = file("ademir/atuadores/ademires.txt");
$adm = "Não se sabe o nome do admin da sala.";
foreach ($ademires_file as $line) {
    list($salaid, $nomeadm) = explode(":", $line);
    $nomeadm = trim($nomeadm);
    if ($salaid === $sala) {
        $adm = "Esta sala é administrada por <b>$nomeadm</b>. :D";
    }
}

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
        <a href="javascript:void(0)" onclick="escolherSala()">[Escolha sua sala]</a><br>
        <?php echo $horario; ?>
        <br>
        <small>
            Tudo programado por <a target="_blank" href="../contato.html">Bruno Borges Paschoalinoto</a> (2º F)<br><br>
            <small><a href="../ademir">[Administrar o Site]</a><br></small>
            <br>Mensagem do dia:<br>
            <div class="mensagem"><?php echo formatar(file_get_contents("ademir/atuadores/motd.txt")); ?>
            </div><br>
        </small>
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

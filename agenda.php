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
    $host  = $_SERVER["HTTP_HOST"];
    $uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    header("Location: http://$host$uri/.");
    die();
}

// Formato de data usado nos arquivos.
$formato = "Y/m/d";

// Formato de data mostrado ao usuário.
$formato_display = "d/m/Y";

// Lista de tabelas com as lições passadas hoje.
$hojes = "";

// Lista de tabelas com as lições passadas em outros dias.
$outras = "";


$hoje = date($formato_display);
$amanha = strtotime("+1 day", time());

$arquivos = glob($pasta . "*");
usort($arquivos, function($a, $b) {
    return filectime($a) < filectime($b);
});

foreach ($arquivos as $file) {
    // Executa uma chegagem e pula arquivos padrão.
    if ("." === $file) continue;
    if (".." === $file) continue;
    if (".qc" === $file) continue;

    // Cria uma array com as linhas do arquivo.
    $arquivo = file($file);

    // Matéria da lição, formatada.
    $mat = formatar(trim($arquivo[0]));

    // Lista de elementos sintáticos para manter a coerência caso o arquivo se trate de uma prova.
    $v = "fez";
    $ent = "de entrega";
    $gabaritei = "Gabaritei";
    $classe = "entrada";
    $top = "valign=\"top\"";
    $semi = "class=\"semiimportante\"";

    // Alterar os elementos sintáticos caso o arquivo seja, de fato, uma prova.
    if (strpos($mat, "PROVA - ") !== false) {
        $mat = str_replace("PROVA - ", "", $mat);
        $v = "estudou";
        $ent = "da prova";
        $gabaritei = "Estou careca de estudar";
        $classe .= " prova";
    }

    // Variável a conter a tabela a ser gerada.
    $final = "<acronym title=\"ID de lição: " . $file . "\"><table class=\"$classe\">\n";

    // Calcula a data de criação do arquivo.
    $datacri = filectime($file);

    // Data em que a lição foi criada.
    $pass = date($formato_display, $datacri);

    // Linha 1: a matéria da lição.
    $materia = "<tr><td $top><span $semi>Matéria:</span> </td><td $top>$mat<br></td></tr>\n";

    // Linha 2: a data em que a lição foi passada.
    $passada = "<tr><td $top><span $semi>Passada em:</span> </td><td $top>$pass<br></td></tr>";

    // Calcula a data de entrega.
    $datastr = $arquivo[1];
    $entrega = strtotime($datastr);

    // Muda o dia da semana para "amanhã", para dar destaque às lições para amanhã.
    $datafin = date($formato_display, $entrega);
    $semanal = semana(date("l", $entrega));
    if (date($formato_display, $amanha) == $datafin) {
        $semanal = "<b><i>amanhã</i></b>";
    }

    // Linha 2: a data de entrega da lição.
    $datapre = "<tr><td $top><span $semi>Data $ent:</span> </td><td $top>$datafin (<b>$semanal</b>)<br></td></tr>\n";

    // Linha 3: as informações da lição, formatadas.
    $dadosarr = $arquivo;
    unset($dadosarr[0]);
    unset($dadosarr[1]);
    $dat = formatar_array($dadosarr);
    $dados = "<tr><td $top><span $semi>Informações:</span> </td><td $top>$dat<br></td></tr>\n";

    // Cria a variável final para a lição.
    $final .= $materia;

    // Checkbox para o usuário manter controle sobre as lições já feitas.
    $check = "<tr><td $top><span $semi>Já $v?</span> </td><td $top><input type=\"checkbox\" id=\"" . basename($file) . "\" onclick=\"toggleFeita(this.id)\">$gabaritei<br></td></tr>\n";

    // Coloca as lições na lista de tavelas de acordo com sua data de criação.
    if ($pass == $hoje) {
        $final .= $datapre . $dados. $check . "</table></acronym><br>\n";
        $hojes .= $final;
    } else {
        $final .= $passada . $datapre . $dados . $check . "</table></acronym><br>\n";
        $outras .= $final;
    }

    // Próximo arquivo.
}

// Checagens para cobrir casos onde uma das listas de tabelas está vazia.
if ($hojes == "") {
    $hojes = "<i>Nenhuma lição foi passada hoje.</i><br><br>\n";
}
if ($outras == "") {
    $outras = "<i>Nenhuma lição foi passada em outros dias...</i>\n";
}

// Imprime o início do arquivo, guardado num arquivo separado por ser muito comum.
include("extras/top.php");

?>
<br>
<br>
<span class="importante">Lições passadas hoje:</span><br><br>
<?php echo $hojes; ?>
<hr>
<br>
<span class="importante">Lições passadas em outros dias:</span><br><br>
<?php echo $outras; ?>
<br>
<script src="extras/javascript.js"></script>
</body>
</html>
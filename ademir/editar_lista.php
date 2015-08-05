<?php
// Esta página lista as lições de uma certa sala e
// imprime uma lista de links para editar ou deletar
// uma certa lição, evitando o uso dos IDs.

// Escrito por Bruno Borges Paschoalinoto.

// Usar a timezone daqui.
date_default_timezone_set("America/Sao_Paulo");

// Sala padrão caso nenhuma outra seja especificada: a minha.
$sala = "1E";

// Usa a sala enviada pelo padrão GET "sala".
if (isset($_GET['sala']))
    $sala = $_GET['sala'];

// Pasta com os arquivos da sala.
$pasta = "../salas/$sala/";

// Lê os arquivos da sala e os ordena por data de criação.
$arquivos = glob($pasta . "*");
usort($arquivos, function($a, $b) {
    return filectime($a) < filectime($b);
});

// Variável para manter cada um dos links das lições.
$final = "";

// Ler cada um dos arquivos.
foreach ($arquivos as $file) {
    // Checagem sobre o nome base do arquivo para pular arquivos padrão e o contador.
    $bas = basename($file);
    if ('.' === $bas) continue;
    if ('..' === $bas) continue;
    if ('.qc' === $bas) continue;

    // Lista das linhas do arquivo.
    $arr = file($file);

    // Matéria da lição.
    $mat = "<b>" . trim($arr[0]) . "</b>";

    // Data de entrega.
    $data = "<b>" . date("d/m/Y", strtotime(trim($arr[1]))) . "</b>";

    // Identificação da lição.
    $iden = "Lição de $mat, para";

    if (strpos($mat, "PROVA - ") !== false)
        $iden = "Prova de " . str_replace("PROVA - ", "", $mat) . ", em";

    $iden .= " $data";

    // Coloca os links na lista final de links.
    $final .= "<a href='edita.php?sala=$sala&id=$bas'>$iden</a> -- ";
    $final .= "<a href='atuadores/deleta.php?sala=$sala&id=$bas&lista=1'>[Deletar]</a><br>";
}

// Cobre casos em que a sala é inválida ou não há nenhuma lição.
if ($final == "")
    $final = "Nenhuma lição disponível para edição.";

?>
<html>
    <head>
        <title>Editar lições do 1ºE</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
    </head>

    <body align="center">
        <h1>Painel Administrativo - Edição de Lições</h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (1º E)</small>
        <br>
        <br>
        Lista de lições do <?php echo $sala[0] . "º " . $sala[1]; ?>:<br>
        <br>
        <?php echo $final; ?>
        </form>
    </body>
</html>

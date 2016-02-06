<?php
// Esta página lista as lições de uma certa sala e
// imprime uma lista de links para editar ou deletar
// uma certa lição, evitando o uso dos IDs.

// Escrito por Bruno Borges Paschoalinoto.


// Inclui o arquivo com as funções compartilhadas.
include("../extras/funcs.php");

include("../superademir/auth/authfunctions.php");
require_login();
$sala = $_SERVER["PHP_AUTH_USER"];

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
    $final .= "<a href='edita.php?id=$bas'>$iden</a> -- ";
    $final .= "<a href='atuadores/deleta.php?sala=$sala&id=$bas&lista=1'>[Deletar]</a><br>";
}

// Cobre casos em que a sala é inválida ou não há nenhuma lição.
if ($final == "")
    $final = "Nenhuma lição disponível para edição.<br><br><a href=\".\">Voltar ao Painel</a><br>";

?>
<html>
    <head>
        <title>Editar lições do 1ºE</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body align="center">
        <h1>Edição de Lições</h1>
        <a href=".">[Voltar ao Painel]</a><br>
        <br>
        <a href="..">[Página inicial]</a>
        <br>
        <br>
        <br>
        Lista de lições do <?php echo $sala[0] . "º " . $sala[1]; ?>:<br>
        <br>
        <br>
        <?php echo $final; ?>
        </form>
    </body>
</html>

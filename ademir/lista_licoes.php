<?php
// Esta página lista as lições de uma certa sala e
// imprime uma lista de links para editar ou deletar
// uma certa lição, evitando o uso dos IDs.

// Escrito por Bruno Borges Paschoalinoto.


// Inclui o arquivo com as funções compartilhadas.
include("../extras/database.php");
require_login();
$sala = getUser();
$nome = nomeSala($sala);

// Lê os arquivos da sala e os ordena por data de criação.
$licoes = getProperty($sala, "licoes");
usort($licoes, function($a, $b) {
    return dataToTime($b["para"]) < dataToTime($a["para"]);
});

// Variável para manter cada um dos links das lições.
$final = "";

// Ler cada um dos arquivos.
foreach ($licoes as $licao) {
    if (isset($licao["removed"])) if ($licao["removed"]) continue;

    $guid = $licao["guid"];
    $mat = "<b>" . $licao["materia"] . "</b>";
    $data = "<b>" . date("d/m/Y", dataToTime($licao["para"])) . "</b>";
    $iden = "Lição de $mat, para";

    if ($licao["prova"])
        $iden = "Prova de $mat, em";
    $iden .= " $data";

    $final .= "<a href=\"editar_licao.php?guid=$guid\">$iden</a> -- ";
    $final .= "<a href=\"atuadores/deleta_licao.php?guid=$guid\">[Deletar]</a><br>";
}

// Cobre casos em que a sala é inválida ou não há nenhuma lição.
if ($final == "")
    $final = "Nenhuma lição disponível para edição.<br><br><a href=\".\">Voltar ao Painel</a><br>";

?>
<html>
    <head>
        <title>Lista de lições do <?php echo $nome; ?></title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body align="center">
        <h1>Lista de Lições</h1>
        <a href=".">[Voltar ao Painel]</a><br>
        <br>
        <a href="../sala/<?php echo $sala; ?>">[Página inicial]</a><br>
        <br>
        <br>
        <br>
        Lista de lições do <?php echo $nome; ?>:<br>
        <br>
        <br>
        <?php echo $final; ?>
        </form>
    </body>
</html>

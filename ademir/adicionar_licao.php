<?php

include("../extras/database.php");
require_login();

$sala = getUser();
$nome = nomeSala($sala);

include("../extras/horario2html.php");

$horario = "";
if (hasHorario($sala)) {
    $horario = getHorarioAdder($sala);
}

$hj = date("Y-m-d");

?>

<html>
    <head>
        <title>Adicionar Lições</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Adicionar Lições (<?php echo $nome; ?>)</h1>
        <a href=".">[Voltar ao Painel]</a><br>
        <br>
        <a href="../sala/<?php echo $sala; ?>">[Página inicial]</a><br>
        <br>
        <a href="lista_licoes.php">[Ir para lista de lições]</a>
        <br>
        <br>
        <?php echo $horario; ?>
        <br>
        <form method="POST" action="atuadores/adiciona_licao.php" class="licform">
            <input type="text" name="materia" id="materia" placeholder="Matéria da lição/prova"><br>
            <input type="checkbox" name="prova">É prova<br>
            Data de entrega: <input type="date" name="calendario" id="calendario" value="<?php echo $hj; ?>"><br>
            <textarea name="info" placeholder="Coloque aqui as informações a respeito da lição/prova."></textarea>
            <br><input type="submit" value="Adicionar lição">
        </form>
        <script src="../extras/add_edit.js"></script>
        <script>
        </script>
    </body>
</html>

<?php

include("../extras/database.php");
require_login();

$sala = getUser();
$nome = nomeSala($sala);

include("../extras/horario2html.php");

$horario = "";
if (hasHorario($sala)) {
    $conts = getHorarioAdder($sala);
    $horario = "<br><a id=\"horlink\" href=\"javascript:void(0)\" onclick=\"horario();\">[Ver horário de aulas]</a><br>\n
    <span id=\"hor\">$conts</span>";
}

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
        <a href="../sala/<?php echo $sala; ?>">[Página inicial]</a>
        <br>
        <?php echo $horario; ?>
        <br>
        <form method="POST" action="atuadores/adiciona_licao.php" class="licform">
            <input type="text" name="materia" placeholder="Matéria da lição/prova"><br>
            <input type="checkbox" name="prova">É prova<br>
            Dia <input class="datasel" type="number" min="1" max="31" id="dia" name="dia">
            do <input class="datasel" type="number" min="1" max="12" id="mes" name="mes">
            de <input class="yearsel" type="number" min="2016" max="2100" id="ano" name="ano"><br>
            <textarea name="info" placeholder="Coloque aqui as informações a respeito da lição/prova."></textarea><br>
            <br><input type="submit" value="Adicionar lição">
        </form>
        <script src="../extras/add_edit.js"></script>
        <script>
            var data = new Date();
            ano.value = data.getFullYear();
            mes.value = data.getMonth() + 1;
            dia.value = data.getDate();
        </script>
    </body>
</html>

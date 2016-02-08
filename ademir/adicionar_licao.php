<?php

include("../extras/database.php");
require_login();

$sala = getUser();
$nome = nomeSala($sala);

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
        <br>
        <form method="POST" action="atuadores/adiciona_licao.php">
            <table align="center">
            <tr><td>Matéria: </td><td><input type="text" name="materia"></tr>
            <tr><td>É prova? </td><td><input type="checkbox" name="prova"></tr>
            <tr><td>Entrega: </td><td>
                Dia <input class="datasel" type="number" min="1" max="31" id="dia" name="dia">
                do <input class="datasel" type="number" min="1" max="12" id="mes" name="mes">
                de <input class="yearsel" type="number" min="2016" max="2100" id="ano" name="ano"></tr>
            <tr><td>Informações: </td><td><textarea rows="20" cols="75" name="info"></textarea></tr>
            </table>
            <br><input type="submit" value="Adicionar lição">
        </form>
        <script>
            var data = new Date();
            var ano = data.getFullYear();
            var mes = data.getMonth() + 1;
            var dia = data.getDate();
            document.getElementById("dia").value = dia;
            document.getElementById("mes").value = mes;
            document.getElementById("ano").value = ano;
        </script>
    </body>
</html>

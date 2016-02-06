<?php

include("../superademir/auth/authfunctions.php");
require_login();

$sala = $_SERVER["PHP_AUTH_USER"];
$nome = $sala[0] . "º " . $sala[1];

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
        <form method="GET" action="atuadores/adiciona.php">
            <table align="center">
            <tr><td>Matéria: </td><td><input type="text" name="materia"></tr>
            <tr><td>Data de entrega <small><small>(aaaa/m/d, exemplo: 2015/3/12)</small></small>: </td><td><input type="text" id="data" name="data"></tr>
            <tr><td>Informações: </td><td><textarea rows="20" cols="75" name="dados"></textarea></tr>
            </table>
            <br><input type="submit" value="Adicionar">
        </form>
        <script>
            var data = new Date();
            var ano = data.getFullYear();
            var mes = data.getMonth() + 1;
            document.getElementById("data").value = ano + "/" + mes + "/";
        </script>
    </body>
</html>

<?php

include("../extras/database.php");
require_login();

?>

<html>
    <head>
        <title>Mensagem do Dia</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Adicionar Mensagem da Sala</h1>
        <small>
            Tudo programado por Bruno Borges Paschoalinoto (2º F)<br>
            <a href=".">[Voltar ao Painel]</a><br>
        </small>
        <br>
        <br>
        Digite uma mensagem para todos os da sua sala verem:<br>
        <br>
        <form method="POST" action="atuadores/seta_msg.php" class="licform">
            <textarea name="msg"></textarea><br>
            <input class="buttonlink btnblue" type="submit" value="Adicionar">
        </form>
    </body>
</html>

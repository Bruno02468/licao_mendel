<?php

include("../extras/database.php");
require_login();
$sala = getUser();
$msg = htmlspecialchars(getProperty($sala, "msg"));

?>

<html>
    <head>
        <title>Mensagem do Dia</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Adicionar Mensagem do Admin</h1>
        <small>
            Tudo programado por Bruno Borges Paschoalinoto (2º F)<br><br>
        </small>
        <a href=".">[Voltar ao Painel]</a><br>
        <br>
        Edite a mensagem para as pessoas da sua sala:<br>
        <br>
        <form method="POST" action="atuadores/seta_msg.php" class="licform">
            <textarea name="msg"><?php echo $msg ?></textarea><br>
            <input type="submit" value="Salvar">
        </form>
        ou você pode <a href="atuadores/deleta_msg.php">clicar aqui para removê-la</a>.
    </body>
</html>

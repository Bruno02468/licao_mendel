<?php

include("../extras/database.php");
require_login();
$sala = getUser();
$msg = getProperty($sala, "msg");

$admvisao = "";
if (isset($_GET["admvisao"])) {
    $admvisao = "<input type=\"hidden\" name=\"admvisao\" value=\"on\">";
}

?>

<html>
    <head>
        <title>Mensagem do Dia</title>
        <link rel="stylesheet" href="../extras/admiravel_estilo_novo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Adicionar Mensagem da Sala</h1>
        <a class="buttonlink" href=".">Voltar ao Painel</a><br>
        <br>
        <br>
        Edite a mensagem para as pessoas da sua sala:<br>
        <br>
        <form method="POST" action="atuadores/seta_msg.php" class="licform">
            <?php echo $admvisao; ?>
            <textarea name="msg"><?php echo $msg ?></textarea><br>
            <input class="buttonlink btnblue" type="submit" value="Salvar">
        </form>
        ou você pode <a class="buttonlink btnred" href="atuadores/deleta_msg.php">removê-la</a>.
    </body>
</html>

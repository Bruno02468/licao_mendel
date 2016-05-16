<?php

include("../extras/database.php");
require_login();
$sala = getUser();
$msg = htmlspecialchars(getProperty($sala, "msg"));

$admvisao = "";
if (isset($_GET["admvisao"])) {
    $admvisao = "<input type=\"hidden\" name=\"admvisao\" value=\"on\">";
}

?>

<html>
    <head>
        <title>Mensagem da Sala</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Adicionar Mensagem da Sala</h1>
        <a class="buttonlink" href=".">Voltar ao Painel</a><br>
        <br>
        <br>
        Digite uma mensagem para todos os da sua sala verem:<br>
        <br>
        <form method="POST" action="atuadores/seta_msg.php" class="licform">
            <?php echo $admvisao; ?>
            <textarea name="msg"></textarea><br>
            <input class="buttonlink btnblue" type="submit" value="Adicionar">
        </form>
    </body>
</html>

<?php

include("../extras/database.php");
require_login("borginhos");

?>

<html>
    <head>
        <title>Mensagem do Dia</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Mensagem do Dia</h1>
        <a class="buttonlink btnred" href=".">Voltar ao Superpainel</a><br>
        <br>
        <a class="buttonlink" href="..">Página inicial</a>
        <br>
        <br>
        <br>
        <form method="POST" action="atuadores/set_motd.php" class="licform">
            <textarea name="motd"><?php echo htmlspecialchars(file_get_contents("atuadores/motd.txt")); ?></textarea>
            <br>
            <input class="buttonlink btnblue" type="submit" value="Salvar">
        </form>
    </body>
</html>

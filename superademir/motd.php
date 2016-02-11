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
        <small>
            Tudo programado por Bruno Borges Paschoalinoto (2º F)<br>
            <a href=".">[Voltar ao Painel]</a><br>
            <a href="..">[Página inicial]</a>
        </small>
        <br>
        <br>
        <br>
        <form method="POST" action="atuadores/set_motd.php" class="licform">
            <table align="center">
            <tr>
                <td>Mensagem do dia: </td>
                <td><textarea name="motd"><?php echo htmlspecialchars(file_get_contents("atuadores/motd.txt")); ?></textarea></td>
            </tr>
            </table>
            <input type="submit" value="Salvar">
        </form>
    </body>
</html>

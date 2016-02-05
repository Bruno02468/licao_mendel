<?php

include("auth/authfunctions.php");
require_login("borginhos");

?>

<html>
    <head>
        <title>Lista de Administradores</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Lista de Administradores</h1>
        <small>
            Tudo programado por Bruno Borges Paschoalinoto (2º F)<br>
            <a href=".">[Voltar ao Painel]</a><br>
            <a href="..">[Página inicial]</a>
        </small>
        <br>
        <br>
        <br>
        <form method="POST" action="atuadores/set_ademires.php">
            Lista de administradores do site - no formato <code>Sala:Nome</code>, um em cada linha:<br><br>
            <textarea rows="20" cols="75" name="lista"><?php echo htmlspecialchars(file_get_contents("atuadores/ademires.txt")); ?></textarea><br>
            <br>
            <input type="submit" value="Salvar">
        </form>
    </body>
</html>

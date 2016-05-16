<?php

include("../extras/database.php");
require_login("borginhos");

?>

<html>
    <head>
        <title>Adicionar Sala</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Adicionar Sala</h1>
        <a class="buttonlink btnred" href=".">Voltar ao Superpainel</a><br>
        <br>
        <a class="buttonlink" href="..">Página inicial</a><br>
        <br>
        <br>
        <form method="POST" action="atuadores/adiciona_sala.php">
            <table align="center">
            <tr><td>ID de sala: </td><td><input type="text" name="id"></tr>
            <tr><td>Nome do Administrador: </td><td><input type="text" name="ademir"></tr>
            <tr><td>Senha do Administrador: </td><td><input type="password" name="pass"></tr>
            </table>
            <br><input class="buttonlink btnblue" type="submit" value="Adicionar sala">
        </form>
    </body>
</html>

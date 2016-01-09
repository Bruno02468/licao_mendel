<?php

#require_login("borginhos");

?>

<html>
    <head>
        <title>Adicionar credenciais</title>
        <link rel="stylesheet" href="../../extras/estilo.css">
        <meta charset="UTF-8">
    </head>

    <body style="text-align: center;">
        <h1>Adicionar credenciais</h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (1ª E)</small>
        <br>
        <br>
        <form method="POST" action="actions/add.php">
            Nome de usuário: <input type="text" name="user"><br>
            Senha: <input type="password" name="pass"><br>
            <input type="submit" value="Pode rodar!">
        </form>
    </body>
</html>
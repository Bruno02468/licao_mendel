<?php

include("../../extras/funcs.php");
include("authfunctions.php");

$user = req_get("user");

?>
<html>
    <head>
        <title>Editando credenciais</title>
        <link rel="stylesheet" href="../../extras/estilo.css">
        <meta charset="UTF-8">
    </head>

    <body style="text-align: center;">
        <h1>Editando credenciais</h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (1ª E)</small>
        <br>
        <br>
        <form method="POST" action="actions/edit.php">
            <input type="hidden" name="user" value="<?php echo $user; ?>"><br>
            Senha: <input type="password" name="newpass"><br>
            <input type="submit" value="Pode rodar!">
        </form>
    </body>
</html>
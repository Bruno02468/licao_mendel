<?php

include("../../extras/funcs.php");
include("authfunctions.php");
require_login("borginhos");

$user = req_get("user");

?>
<html>
    <head>
        <title>Editando credenciais</title>
        <link rel="stylesheet" href="../../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Editando credenciais</h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (2º F)</small>
        <br>
        <br>
        <form method="POST" action="actions/edit.php">
            <input type="hidden" name="user" value="<?php echo $user; ?>"><br>
            Senha: <input type="password" name="newpass"><br>
            <input type="submit" value="Pode rodar!">
        </form>
        <a href="actions/remove.php?user=<?php echo $user; ?>">
            Deletar credenciais do usuário <?php echo $user; ?>
        </a>
    </body>
</html>
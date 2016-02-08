<?php

include("../extras/database.php");
require_login("borginhos");

$links = "";
$json = getFullJSON();
foreach ($json as $id => $sala) {
    $nome = nomeSala($id);
    $links .= "<a href=\"editar_sala.php?id=$id\">$nome</a><br>";
}

?>
<html>
    <head>
        <title>Painel Superadministrativo</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Painel Superadministrativo</h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (2º F)</small>
        <br>
        <br>
        <br>
        <b>Você está logado como o <b>superadministrador</b>.</b>
        <br>
        <div class="h2">
            <a href="..">[Página inicial]</a><br>
            <br>
            <a href="motd.php">[Mensagem do Dia]</a><br>
            <br>
            Mudar senha mestra:
            <form action="atuadores/set_god.php" method="POST">
                <input type="password" name="pass">
                <input type="submit" value="Pode rodar!">
            </form>
            <a href="nova_sala.php">[Nova sala]</a><br>
            <br>
            Editar salas:
            <br>
            <?php echo $links; ?>
        </div>
    </body>
</html>

<?php

include("../extras/database.php");
require_login("borginhos");

$links = "";
$json = getFullJSON();
foreach ($json as $id => $sala) {
    $nome = nomeSala($id);
    $links .= "<a class=\"buttonlink smallbtn btnblue\" href=\"editar_sala.php?id=$id\">$nome</a>&nbsp;<br>";
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
            <a class="buttonlink bigbtn btnred" href="..">Página inicial</a><br>
            <br>
            <a class="buttonlink bigbtn btnblue" href="motd.php">Mensagem do Dia</a><br>
            <br>
            <a class="buttonlink bigbtn" href="nova_sala.php">Adicionar sala</a><br>
            <br>
            Mudar senha mestra:
            <form action="atuadores/set_god.php" method="POST">
                <input type="password" name="pass">
                <input class="buttonlink" type="submit" value="Pode rodar!">
            </form>
            Editar salas:
            <br>
            <?php echo $links; ?>
        </div>
    </body>
</html>

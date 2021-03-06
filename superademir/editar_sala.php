<?php

include("../extras/database.php");
require_login("borginhos");

$id = req_get("id");
$nome = nomeSala($id);
if (!salaExists($id)) die("Sala não existe!");

$ademir = getProperty($id, "ademir");

?>

<html>
    <head>
        <title>Editando <?php echo $id; ?></title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Editando Sala <?php echo $id; ?></h1>
        <a class="buttonlink btnred" href=".">Voltar ao Superpainel</a><br>
        <br>
        <a class="buttonlink" href="..">Página inicial</a>
        <br>
        <br>
        <form method="POST" action="atuadores/edita_sala.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <table align="center">
            <tr><td>Nome do Administrador: </td><td><input type="text" name="ademir" value="<?php echo $ademir; ?>"></tr>
            <tr><td>Senha do Administrador: </td><td><input type="password" name="pass"></tr>
            </table>
            <br><input type="submit" value="Salvar mudanças">
        </form>
    </body>
</html>

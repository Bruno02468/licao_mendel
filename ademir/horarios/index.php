<?php

include("../auth/authfunctions.php");
require_login();
$sala = $_SERVER["PHP_AUTH_USER"];
$nome = $sala[0] . "º " . $sala[1];

$link = "<a href=\"adicionar.php\">[Adicionar o horário para o $nome]</a>";

if (file_exists("hors/$sala")) {
    $link = "<a href=\"editar.php\">[Editar o horário para o $nome]</a>";
}

?>

<html>
    <head>
        <title>Horários</title>
        <link rel="stylesheet" href="../../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body style="text-align: center;">
        <h1>Horários das salas</h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (2º F)</small>
        <br>
        <br>
        <br>
        <div class="h2">
            <a href="..">[Voltar]</a><br>
            <br>
            <?php echo $link; ?>
        </div>
    </body>
</html>
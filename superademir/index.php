<?php

include("auth/authfunctions.php");
require_login("borginhos");

include("../extras/funcs.php");
$sala = $_SERVER["PHP_AUTH_USER"];
$nome = $sala[0] . "º " . $sala[1];

$link = "<a href=\"horarios/adicionar.php\">[Adicionar o horário do $nome]</a>";

if (file_exists("horarios/hors/$sala.horario")) {
    $link = "<a href=\"horarios/editar.php\">[Editar o horário do $nome]</a>";
}

?>
<html>
    <head>
        <title>Painel Administrativo</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
    </head>

    <body style="text-align: center;">
        <h1>Painel Administrativo</h1>
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
            <a href="salas.php">[Salas]</a><br>
            <br>
            <a href="auth">[Credenciais]</a><br>
            <br>
            <a href="ademires.php">[Lista de Admins]</a><br>
            <br>
        </div>
        <script>
            document.getElementById("sala").value = localStorage["sala"];
        </script>
    </body>
</html>

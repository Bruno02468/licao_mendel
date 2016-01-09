<?php

include("authfunctions.php");
#require_login("borginhos");

$links = array();
$lines = file(".shadow");
foreach ($lines as $line) {
    list($user, $hashed, $salt) = explode("§", $line);
    array_push($links, "<a href=\"editar.php?user=$user\">$user</a>");
}


?>
<html>
    <head>
        <title>Gerenciamento de Credenciais</title>
        <link rel="stylesheet" href="../../extras/estilo.css">
        <meta charset="UTF-8">
    </head>

    <body style="text-align: center;">
        <h1>Gerenciamento de Credenciais</h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (1ª E)</small>
        <br>
        <br>
        <br>
        <div class="h2">
            <a href="..">[Voltar]</a><br>
            <br>
            <a href="adicionar.php">[Adicionar credenciais]</a><br>
            <br>
            Editar credenciais: <?php echo implode(", ", $links); ?><br>
            <br>
        </div>
    </body>
</html>
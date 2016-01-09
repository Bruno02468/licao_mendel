<?php

include("auth/authfunctions.php");
require_login();

$scan = scandir("../salas/");

$links = array();
foreach ($scan as $sala) {
    if ($sala[0] == '.') continue;
    $nome = $sala[0] . "º " . $sala[1];
    array_push($links, "<a href=\"editar_lista.php?sala=$sala\">$nome</a>");
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
        <small>Tudo programado por Bruno Borges Paschoalinoto (1ª E)</small>
        <br>
        <br>
        <br>
        <div class="h2">
            <a href="..">[Página inicial]</a><br>
            <br>
            <a href="cadastra.html">[Adicionar lições]</a><br>
            <br>
            Editar lições: <?php echo implode(", ", $links); ?><br>
            <br>
            <a href="horarios">[Edição dos Horários]</a><br>
            <br>
            <a href="motd.php">[Edição da Mensagem do Dia]</a>
        </div>
        <script>
            document.getElementById("sala").value = localStorage["sala"];
        </script>
    </body>
</html>

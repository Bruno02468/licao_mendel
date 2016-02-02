<?php

include("auth/authfunctions.php");
include("../extras/funcs.php");

require_login();
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
        <b>Você está logado como o administrador do <u><?php echo $nome; ?></u>.</b>
        <br>
        <div class="h2">
            <a href="../sala/<?php echo $sala; ?>">[Página inicial]</a><br>
            <br>
            <a href="cadastra.php">[Adicionar lições]</a><br>
            <br>
            <a href="editar_lista.php">[Editar lições]</a><br>
            <br>
            <?php echo $link; ?><br>
            <br>
        </div>
        Links restritos:<br>
        <br>
        <a href="motd.php">[Edição da Mensagem do Dia]</a><br>
        <br>
        <a href="auth/">[Gerenciamento de Credenciais]</a><br>
        <br>
        <a href="salas.php">[Gerenciamento de Salas]</a>
        <script>
            document.getElementById("sala").value = localStorage["sala"];
        </script>
    </body>
</html>

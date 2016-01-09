<?php

include("auth/authfunctions.php");
require_login();
$sala = $_SERVER["PHP_AUTH_USER"];
$nome = $sala[0] . "º " . $sala[1];

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
        Você está logado como o representante do <?php echo $nome; ?>.
        <br>
        <div class="h2">
            <a href="..">[Página inicial]</a><br>
            <br>
            <a href="cadastra.php">[Adicionar lições]</a><br>
            <br>
            <a href="editar_lista.php">[Editar lições]</a><br>
            <br>
            <a href="horarios">[Edição dos Horários]</a><br>
            <br>
        </div>
        Links restritos:<br>
        <br>
        <a href="motd.php">[Edição da Mensagem do Dia]</a><br>
        <br>
        <a href="auth/">[Gerenciamento de Credenciais]</a>
        <script>
            document.getElementById("sala").value = localStorage["sala"];
        </script>
    </body>
</html>

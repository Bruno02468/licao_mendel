<?php

include("../extras/database.php");

require_login();
$sala = getUser();
$nome = nomeSala($sala);

$horlink = "<a href=\"adicionar_horario.php\">[Adicionar o horário do $nome]</a>";
if (hasHorario($sala)) {
    $horlink = "<a href=\"editar_horario.php\">[Editar o horário do $nome]</a>";
}

$msglink = "<a href=\"adicionar_msg.php\">[Adicionar uma mensagem do admin]</a>";
if (hasMsg($sala)) {
    $msglink = "<a href=\"editar_msg.php\">[Editar a mensagem do admin]</a>";
}

?>
<html>
    <head>
        <title>Painel Administrativo</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
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
            <a href="adicionar_licao.php">[Adicionar lições]</a><br>
            <br>
            <a href="lista_licoes.php">[Editar/remover lições]</a><br>
            <br>
            <?php echo $horlink; ?><br>
            <br>
            <?php echo $msglink; ?>
        </div>
        <script>
            document.getElementById("sala").value = localStorage["sala"];
        </script>
    </body>
</html>

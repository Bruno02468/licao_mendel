<?php

include("../extras/funcs.php");

include("auth/authfunctions.php");
require_login();
$sala = $_SERVER["PHP_AUTH_USER"];

$id = req_get('id');

$pasta = "../salas/" . $sala . "/";
$arquivo = $pasta . $id;
if (!file_exists($pasta) || !file_exists($arquivo)) {
    die("404");
}

$conteudo = htmlspecialchars(file_get_contents($arquivo));

?>

<html>
    <head>
        <title>Editando Lição <?php echo $sala . $id; ?></title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body align="center">
        <h1>Painel Administrativo - Edição</h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (2º F)</small>
        <br>
        <br>
        <br>
        <form method="GET" action="atuadores/edita.php">
            <input type="hidden" value="<?php echo $id; ?>" name="id">
            <textarea rows="15" cols="60" name="dados"><?php echo $conteudo; ?></textarea><br>
            <input type="submit" value="Atualizar">
        </form>
    </body>
</html>

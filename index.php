<?php

// Inclui o arquivo com as funções compartilhadas.
include("extras/funcs.php");

$scan = scandir("salas/");

$link = "";
foreach ($scan as $sala) {
    if ($sala[0] == '.') continue;
    $nome = $sala[0] . "º " . $sala[1];
    $link .= "<a href=\"sala/$sala\">$nome</a><br><br>";
}

?>
<html>
    <head>
        <title>Lições</title>
        <link rel="stylesheet" href="extras/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body>
        <?php include_once("extras/ga.php"); ?>
        <h1>Site de Lições</h1>
        <br>
        <small>
            Tudo programado por <a target="_blank" href="contato.html">Bruno Borges Paschoalinoto</a> (1º E)<br><br>
            <a href="ademir/">[Administrar o Site]</a><br>
            </div><br>
        </small>
        <big><big>
            <br>
            Escolha sua sala:
            <br>
            <br>
            <?php echo $link; ?>
            <br>
        </big></big>
    </body>
</html>

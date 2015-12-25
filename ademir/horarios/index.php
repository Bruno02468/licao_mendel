<?php

$scan = scandir("../../salas/");

$edits = array();
$adds = array();
foreach ($scan as $sala) {
    if ($sala[0] == '.') continue;
    $nome = $sala[0] . "º " . $sala[1];
    if (file_exists("hors/$sala.horario"))
        array_push($edits, "<a href=\"editar.php?sala=$sala\">$nome</a>");
    else
        array_push($adds, "<a href=\"adicionar.php?sala=$sala\">$nome</a>");
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
        <small>Tudo programado por Bruno Borges Paschoalinoto (1ª E)</small>
        <br>
        <br>
        <br>
        <div class="h2">
            <a href="..">[Voltar]</a><br>
            <br>
            Adicionar horário: <?php echo implode(", ", $adds); ?><br>
            <br>
            Editar horário: <?php echo implode(", ", $edits); ?>
        </div>
    </body>
</html>
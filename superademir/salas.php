<?php

include("auth/authfunctions.php");
require_login("borginhos");

$scan = scandir("../salas");
$salas = array();
foreach ($scan as $dir) {
    if ($dir[0] == ".") continue;
    array_push($salas, $dir[0] . "º " . $dir[1]);
}
$salas = implode(", ", $salas);

?>
<html>
    <head>
        <title>Gerenciamento de Salas</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Gerenciamento de Salas</h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (2º F)</small>
        <br>
        <br>
        <br>
        <a href=".">[Voltar]<a>
        <br>
        <div class="h2">
            Salas cadastradas: <?php echo $salas; ?><br>
            <br>
            Adicionar sala:
            <form method="POST" action="atuadores/novasala.php">
                ID: <input type="text" name="id"><br>
                <input type="submit" value="Pode rodar">
            </form>
            <br>
            Remover sala:
            <form method="POST" action="atuadores/rmsala.php">
                ID: <input type="text" name="id"><br>
                <input type="submit" value="Pode rodar">
            </form>
            <br>
        </div>
    </body>
</html>
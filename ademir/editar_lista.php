<?php

$sala = "1E";

if (isset($_GET['sala']))
    $sala = $_GET['sala'];

$pasta = "../salas/$sala/";

$arquivos = glob($pasta . "*");
usort($arquivos, function($a, $b) {
    return filectime($a) < filectime($b);
});

$final = "";

foreach ($arquivos as $file) {
    $bas = basename($file);
    if ('.' === $bas) continue;
    if ('..' === $bas) continue;
    if ('.qc' === $bas) continue;
    if ($pasta . 'index.php' === $file) continue;
    if ($pasta . 'get.php' === $file) continue;

    $arr = file($file);
    $mat = $arr[0];
    $data = $arr[1];

    $final .= "<a href='edita.php?sala=$sala&id=$bas'>$mat, para $data</a><br>";

}

if ($final == "")
    $final = "Nenhuma lição disponível para edição.";

?>
<html>
    <head>
        <title>Lista de lições editáveis do 1ºE</title>
        <link rel="stylesheet" href="/stylesheets/dark.css">
        <link rel="stylesheet" href="estilo.css">
        <meta charset="UTF-8">
    </head>

    <body align="center">
        <h1>Painel Administrativo - Edição de Lições</h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (1º E)
        <br>Por um WhatsApp menos confuso :-)</small>
        <br>
        <br>
        Editar uma lição:<br>
        <br>
        <?php echo $final; ?>
        </form>
    </body>
</html>

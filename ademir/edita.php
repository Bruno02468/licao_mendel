<?php

function req($str) {
    if (!isset($_GET[$str])) {
        die("Variável GET \"" . $str . "\" necessária para esta requisição.");
    } else {
        return $_GET[$str];
    }
}

$sala = req('sala');
$id = req('id');

$pasta = "../salas/" . $sala . "/";
$arquivo = $pasta . $id;
if (!file_exists($pasta) or !file_exists($arquivo)) {
    die("404");
}

$conteudo = htmlspecialchars(file_get_contents($arquivo));

?>

<html>
    <head>
        <title>Editando Lição <?php echo $sala . $id; ?></title>
        <link rel="stylesheet" href="/stylesheets/dark.css">
        <link rel="stylesheet" href="estilo.css">
        <meta charset="UTF-8">
    </head>

    <body align="center">
            <h1>Painel Administrativo - Edição</h1>
            <small>Tudo programado por Bruno Borges Paschoalinoto (1º E)
            <br>Por um WhatsApp menos confuso :-)</small>
        <br>
        <br>
        <br>
        <form method="GET" action="atuadores/edita.php">
            <input type="hidden" value="<?php echo $sala; ?>" name="sala">
            <input type="hidden" value="<?php echo $id; ?>" name="id">
            <textarea rows="15" cols="60" name="dados"><?php echo $conteudo; ?></textarea><br>
            <input type="submit" value="Atualizar">
        </form>
    </body>
</html>

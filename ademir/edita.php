<?php
    if (!isset($_GET['sala'])) {
        header("Location: http://bruno02468.com/licao/ademir/");
        die();
    }
    $sala = $_GET['sala'];
    
    if (!isset($_GET['id'])) {
        header("Location: http://bruno02468.com/licao/ademir/");
        die();
    }
    $id = $_GET['id'];
    
    $pasta = "../salas/" . $sala . "/";
    $arquivo = $pasta . $id;
    if (!file_exists($pasta) or !file_exists($arquivo)) {
        header("Location: http://bruno02468.com/ademir/");
        die();
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
            <small>Tudo programado por Bruno Borges Paschoalinoto (1ª E)
            <br>Por um WhatsApp menos confuso :-)</small>
        <br>
        <br>
        <br>
        <form method="GET" action="atuadores/edita.php">
        <input type="hidden" value="<?php echo $sala; ?>" name="sala">
        <input type="hidden" value="<?php echo $id; ?>" name="id">
        <textarea rows="7" cols="50" name="dados"><?php echo $conteudo; ?></textarea><br>
        <input type="submit" value="Atualizar">
        </form>
    </body>
</html>
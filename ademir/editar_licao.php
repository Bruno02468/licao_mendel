<?php

include("../extras/database.php");
require_login();
$sala = getUser();
$nome = nomeSala($sala);

$guid = req_get("guid");

$licao = getProperty($sala, "licoes")[getIndexByGuid($sala, $guid)];

$materia = htmlspecialchars($licao["materia"]);

$calen = date("Y-m-d", dataToTime($licao["para"]));

$prova = $licao["prova"] ? " checked" : "";
$info = htmlspecialchars($licao["info"]);

include("../extras/horario2html.php");

$horario = "";
if (hasHorario($sala)) {
    $horario = getHorarioAdder($sala);
}

?>

<html>
    <head>
        <title>Editando Lição</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body align="center">
        <h1>Editando Lição (<?php echo $nome; ?>)</h1>
        <a href="lista_licoes.php">[Voltar à lista de lições]</a><br>
        <br>
        <a href="../sala/<?php echo $sala; ?>">[Página inicial]</a>
        <br>
        <?php echo $horario; ?>
        <br>
        <form method="POST" action="atuadores/edita_licao.php" class="licform">
            <input type="hidden" value="<?php echo $guid; ?>" name="guid">
            <input type="text" name="materia" id="materia" value="<?php echo $materia; ?>"></br>
            <input type="checkbox" name="prova"<?php echo $prova; ?>>É prova</br>
            Data de entrega: <input type="date" name="calendario" id="calendario" value="<?php echo $calen; ?>"><br>
            <textarea name="info"><?php echo $info; ?></textarea></br>
            <input type="submit" value="Atualizar">
        </form>
        <script src="../extras/add_edit.js"></script>
    </body>
</html>

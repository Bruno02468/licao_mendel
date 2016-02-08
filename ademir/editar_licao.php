<?php

include("../extras/database.php");
require_login();
$sala = getUser();
$nome = nomeSala($sala);

$guid = req_get("guid");

$licao = getProperty($sala, "licoes")[getIndexByGuid($sala, $guid)];

$materia = htmlspecialchars($licao["materia"]);
$dia = htmlspecialchars($licao["para"]["dia"]);
$mes = htmlspecialchars($licao["para"]["mes"]);
$ano = htmlspecialchars($licao["para"]["ano"]);
$prova = $licao["prova"] ? " checked" : "";
$info = htmlspecialchars($licao["info"]);

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
        <a href=".">[Voltar ao Painel]</a><br>
        <br>
        <a href="../sala/<?php echo $sala; ?>">[Página inicial]</a><br>
        <br>
        <br>
        <form method="POST" action="atuadores/edita_licao.php">
            <input type="hidden" value="<?php echo $guid; ?>" name="guid">
            <table align="center">
                <tr><td>É prova? </td><td><input type="checkbox" name="prova"<?php echo $prova; ?>></tr>
                <tr><td>Matéria: </td><td><input type="text" name="materia" value="<?php echo $materia; ?>"></tr>
                <tr><td>Entrega: </td><td>
                    Dia <input class="datasel" type="number" min="1" max="31" id="dia" name="dia" value="<?php echo $dia; ?>">
                    do <input class="datasel" type="number" min="1" max="12" id="mes" name="mes" value="<?php echo $mes; ?>">
                    de <input class="yearsel" type="number" min="2016" max="2100" id="ano" name="ano" value="<?php echo $ano; ?>"></tr>
                <tr><td>Informações: </td><td><textarea rows="20" cols="75" name="info"><?php echo $info; ?></textarea></tr>
            </table>
            <input type="submit" value="Atualizar">
        </form>
    </body>
</html>

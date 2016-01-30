<?php

include("../auth/authfunctions.php");
require_login();
$sala = $_SERVER["PHP_AUTH_USER"];
$nome = $sala[0] + "º " + $sala[1];

$js = "var horario = [];\n";
$arq = file("hors/$sala.horario");
foreach ($arq as $line) {
    $t = trim($line);
    $js .= "horario.push(\"$t\");\n";
}

?>

<html>
    <head>
        <title>Editando horário</title>
        <link rel="stylesheet" href="../../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body style="text-align: center;">
        <h1>Editar horário do <?php echo $nome; ?></h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (2º F)</small>
        <br>
        <br>
        Edita aí o horário.<br>
        <br>
        <form method="POST" action="atuadores/adiciona.php">
            <table id="horario">
                <tr style="text-align: center">
                    <td></td><td>Segunda</td><td>Terça</td><td>Quarta</td><td>Quinta</td><td>Sexta</td>
                </tr>
            </table>
            <br>
            <input type="submit" value="Salvar horário">
        </form>
        ou você pode <a href="atuadores/deleta.php">deletar este horário.</a>
        <script>
            <?php echo $js; ?>
            var tabela = document.getElementById("horario");
            var dias = ["segunda", "terça", "quarta", "quinta", "sexta"];
            for (var i = 1; i <= 8; i++) {
                var row = document.createElement("tr");
                var aula = document.createElement("td");
                aula.innerHTML = i + "ª Aula ";
                row.appendChild(aula);
                for (j in dias) {
                    dia = dias[j];
                    var td = document.createElement("td");
                    var inp = document.createElement("input");
                    inp.setAttribute("name", dia + "_" + i);
                    inp.setAttribute("type", "text");
                    var index = (i-1)*5 + parseInt(j);
                    inp.setAttribute("value", horario[index].replace(";", ""));
                    inp.style.width = "125px";
                    td.appendChild(inp);
                    row.appendChild(td);
                }
                tabela.children[0].appendChild(row);
            }
        </script>
    </body>
</html>
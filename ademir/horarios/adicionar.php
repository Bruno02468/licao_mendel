<?php

include("../auth/authfunctions.php");
require_login();
$sala = $_SERVER["PHP_AUTH_USER"];
$nome = $sala[0] + "º " + $sala[1];

?>

<html>
    <head>
        <title>Adicionar horário</title>
        <link rel="stylesheet" href="../../extras/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body style="text-align: center;">
        <h1>Adicionar horário para o <?php echo $nome; ?></h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (2º F)</small>
        <br>
        <br>
        Digita aí seu horário.<br>
        <br>
        <form method="POST" action="atuadores/adiciona.php">
            <table id="horario">
                <tr style="text-align: center">
                    <td></td><td>Segunda</td><td>Terça</td><td>Quarta</td><td>Quinta</td><td>Sexta</td>
                </tr>
            </table>
            <br>
            <input type="submit" value="Adicionar horário">
        </form>
        <script>
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
                    inp.style.width = "100px";
                    td.appendChild(inp);
                    row.appendChild(td);
                }
                tabela.children[0].appendChild(row);
            }
        </script>
    </body>
</html>
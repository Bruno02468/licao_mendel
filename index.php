<?php

// Inclui o arquivo com as funções compartilhadas.
include("extras/database.php");

$anos = array();
$js = "var anos = [];";
foreach (getFullJSON() as $sala => $props) {
    if ($sala[0] == '.') continue;
    $ano = $sala[0];
    if (!array_key_exists($ano, $anos)) {
        $anos[$ano] = array();
    }
    array_push($anos[$ano], $sala);
    $js .= "anos.push(\"$sala\");";
}

$tabela = "<table class=\"listaanos_noborder\"><tr class=\"listaano\">";
$longest = 0;
foreach(array_keys($anos) as $ano) {
    $tabela .= "<td>${ano}<sup class=\"os\"><u>os</u></sup></td>";
    if (count($anos[$ano]) > $longest) $longest = count($anos[$ano]);
}
$tabela .= "</tr>";

for ($i = 1; $i <= $longest; $i++) {
    $tabela .= "<tr>";
    foreach(array_keys($anos) as $ano) {
        if (count($anos[$ano]) >= $i) {
            $sala = $anos[$ano][$i-1];
            $nome = "${ano}º " . $sala[1];
            $tabela .= "<td><a class=\"buttonlink bigbtn\" href=\"javascript:void(0)\" onclick=\"irsala('$sala')\">$nome</a></td>";
        } else {
            $tabela .= "<td></td>";
        }
    }
    $tabela .= "</tr>";
}

$tabela .= "</table>";

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
        <a class="buttonlink btnorange" href="//licoes.com/resumos">Site de Resumos</a><br>
        <br>
        Tudo programado por <a target="_blank" href="contato.html">Bruno Borges Paschoalinoto</a> (2º F)<br>
        <br>
        <a class="buttonlink btnblue" href="ademir/">Administrar o Site</a><br><br>
        <a class="buttonlink btnblue smallbtn" href="superademir/">Superadministrar o site</a><br>
        <big><big>
            <br>
            Escolha sua sala:
            <br>
            <br>
            <?php echo $tabela; ?>
            <br>
        </big></big>
        <script>
            function irsala(idsala) {
                if (window.localStorage)
                    localStorage["sala"] = idsala;
                location.href = "sala/" + idsala;
            }

            <?php echo $js; ?>
            var sala = "";
            if (window.localStorage)
            sala = localStorage["sala"];
            if (sala != "" && anos.indexOf(sala) > -1) {
                location.href = "sala/" + sala;
            }
        </script>
    </body>
</html>

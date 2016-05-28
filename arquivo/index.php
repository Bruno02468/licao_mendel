<?php

include("../extras/database.php");

$json = getFullJSON();

$options = "";
foreach ($json as $index => $sala) {
    $options .= "<option value=\"$index\">" . nomeSala($index) . "</option>";
}

function make_div($a, $c="") {
    return "<div class=\"entradiv$c\">$a</div>";
}

function isoToTime($iso) {
    list($ano, $mes, $dia) = explode("-", $iso);
    $dat = array(
        "dia" => $dia,
        "mes" => $mes,
        "ano" => $ano
    );
    return dataToTime($dat);
}

function ifonly($valname) {
    if (isset($_GET["sala"])) {
        return " value=\"" . req_get($valname) . "\"";
    }
}

$minpas = date("Y") . "-01-01";
$maxpas = date("Y") . "-12-31";

$resultados = "";
$found = 0;
if (isset($_GET["sala"])) {
    $sala = req_get("sala");
    $materia = strtolower(req_get("materia"));
    $passada_min = isoToTime(req_get("passada_min"));
    $passada_max = isoToTime(req_get("passada_max"));
    $para = req_get("para");
    
    $minpas = req_get("passada_min");
    $maxpas = req_get("passada_max");
    
    $licoes = $json[$sala]["licoes"];
    
    foreach ($licoes as $licao) {
        if (!isset($licao["guid"])) continue;
        if (!isset($licao["passada"])) continue;
        if (isset($licao["removed"])) if ($licao["removed"]) continue;
        
        if ($materia !== "") {
            if (strpos(strtolower($licao["materia"]), $materia) === false) {
                continue;
            }
        }
        
        if ($para !== "") {
            if (isoToTime($para) !== dataToTime($licao["para"])) {
                continue;
            }
        }
        
        $pas = dataToTime($licao["passada"]);
        if ($pas > $passada_max || $pas < $passada_min) {
            continue;
        }
        
        $class = "entrada" . ($licao["prova"] ? " prova" : "");
        $resultados .= "<div class=\"$class\">"
            . make_div(formatar($licao["materia"]))
            . make_div(formatar_array(explode("\n", $licao["info"])), " infos")
            . make_div("Passada no dia " . date("d/m/Y", dataToTime($licao["passada"])), " datas")
            . make_div("Para o dia " . date("d/m", dataToTime($licao["para"])), " datas")
            . "</div><br>";
        
        $found++;
    }
    
    $resultados = "<br>Resultados correspondentes (<b>$found</b>):<br><br>$resultados";
}

?>
<html>
    <head>
        <title>Lições Antigas</title>
        <link rel="stylesheet" href="../extras/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body>
        <?php include_once("../extras/ga.php"); ?>
        <h1>Ver lições antigas!</h1>
        Tudo programado por <a target="_blank" href="contato.html">Bruno Borges Paschoalinoto</a> (2º F)<br>
        <br>
        <br>
        Aqui você pode acessar todo o arquivo de lições do site.<br>
        Isso inclui as lições que foram removidas e já passaram.<br>
        <br>
        Campos deixados em branco são ignorados (não restringem a pesquisa).<br>
        <br>
        Divirta-se!<br>
        <br>
        <form action="index.php" method="GET">
            <table style="display: inline-block;" class="licform">
                <tr><td>Especificar sala: </td><td><select id="sala" name="sala"<?php echo ifonly("sala"); ?>><?php echo $options; ?></select></tr>
                <tr><td>Especificar matéria: </td><td><input type="text" name="materia"<?php echo ifonly("materia"); ?>></td></tr>
                <tr><td>
                    Passadas entre: </td><td><input type="date" value="<?php echo $minpas ?>" name="passada_min"> e 
                    <input type="date" value="<?php echo $maxpas ?>" name="passada_max"></td></tr>
                <tr><td>
                    Para o dia: </td><td><input type="date" id="para" name="para"<?php echo ifonly("para"); ?>>
                    <input type="button" onclick="document.getElementById('para').value = '';" class="buttonlink btnorange smallbtn" value="limpar">
                </td></tr>
            </table><br>
            <input type="submit" class="buttonlink" value="Buscar!"><br>
        </form>
        <script>
            if (typeof(Storage) !== "undefined") {
                document.getElementById("sala").value = localStorage["sala"];
            }
        </script>
        
        <?php echo $resultados; ?>
    </body>
</html>

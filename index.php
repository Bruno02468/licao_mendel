<?php
    /* Página inicial para o site de lições.
     * Escrito pelo Bruno Borges Paschoalinoto.
     * Altas programações :-)
     */
    date_default_timezone_set("America/Sao_Paulo");
    
    $sala = "1E";
    if (isset($_GET['sala'])) {
        $sala = $_GET['sala'];
    }
    
    $nome = $sala[0] . "ª " . $sala[1];
    $pasta = "salas/" . $sala . "/";
    if (!file_exists($pasta)) {
        header("Location: http://bruno02468.com/licao/");
        die();
    }
    
    $agora = time();
    $amanha = strtotime('+1 day', $agora);
    $amanhas = "";
    $outras = "";
    
    if ($handle = opendir($pasta)) {
        while (false !== ($file = readdir($handle))) {
            if ('.' === $file) continue;
            if ('..' === $file) continue;
            if ('.qc' === $file) continue;
            if ('index.php' === $file) continue;
            
            $final = "<acronym title='ID de lição: " . $file . "'><table>\n";
            
            $arquivo = file($pasta . $file);
            $materia = "<tr><td valign='top'><span class='semiimportante'>Matéria:</span> </td><td valign='top'>" . trim($arquivo[0]) . "<br></td></tr>\n";
            $datastr = $arquivo[1];
            $entrega = strtotime($datastr);
            
            if ($entrega < $agora) {
                unlink($pasta . $file);
                continue;
            }
            
            $datafin = date("d/m/Y", $entrega); 
            $datapre = "<tr><td valign='top'><span class='semiimportante'>Data de entrega:</span> </td><td valign='top'>" . $datafin . "<br></td></tr>\n";
            
            $dadosarr = $arquivo;
            unset($dadosarr[0]);
            unset($dadosarr[1]);
            $dados = "<tr><td valign='top'><span class='semiimportante'>Informações:</span> </td><td valign='top'>" . join("<br>", $dadosarr) . "<br></td></tr>\n";
            
            $check = "<tr><td valign='top'><span class='semiimportante'>Já fez?</span> </td><td valign='top'><input type='checkbox' id='" . $file . "' onclick='toggleFeita(this.id)'>Gabaritei<br></td></tr>\n";
            $final .= $materia;
            
            
            if ($entrega <= $amanha) {
                $final .= $dados . $check . "</table></acronym><br><br>\n";
                $amanhas .= $final;
            } else {
                $final .= $datapre . $dados. $check . "</table></acronym><br><br>\n";
                $outras .= $final;
            }
            
        }
        closedir($handle);
    }
    
    if ($amanhas == "") {
        $amanhas = "<i>Oba! Sem lição pra amanhã!</i><br><br>\n";
    }
    if ($outras == "") {
        $outras = "<i>Sem outras lições.</i>\n";
    }
    
?>
<html>
    <head>
        <title>Lições - <?php echo $nome; ?></title>
        <link rel="stylesheet" href="/stylesheets/dark.css">
        <link rel="stylesheet" href="estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta charset="UTF-8">
    </head>
    
    <body>
        <?php include_once("ga.php"); ?>
        <center>
            <h1>Visualização de lições da <?php echo $nome; ?></h1>
            <b><a href="agenda.php">[Ver lições passadas hoje]</a><br></b>
            <a href="javascript:horario()">Horário da 1ª E</a><br>
            <a href='horario.png' title='Clique para ver o tamanho completo.' target="_blank" id="hor"></a>
            <small>Tudo programado por Bruno Borges Paschoalinoto (1ª E)
            <br>Por um WhatsApp menos confuso :-)</small>
        </center>
        <div class="valeu">
            <input type="button" onclick="vlw()" value="Esta página me ajudou!">
            (<span id="vlw"><?php echo trim(file_get_contents("contador.txt")); ?></span>)
        </div>
        <br>
        <br>
        <img src="ui.png" style="max-width: 8%" alt="Pois é..." title="Pois é...">
        <br>
        <i><b>Se for para comer pizza junto a pessoas ingratas que não levam em conta todo<br>
        o tempo que eu dediquei a ajudá-las, comerei pizza em casa mil vezes mais satisfeito.<br>
        Eu só queria ajudar, pessoal, só isso. :-(<br>
        ~ Bruno<br></b></i>
        <br>
        <span class="importante">Lições para amanhã:</span><br><br>
        <?php echo $amanhas; ?>
        <hr>
        <span class="importante">Lições para outros dias:</span><br><br>
        <?php echo $outras; ?>

        <script src="javascript.js"></script>
    </body>
</html>
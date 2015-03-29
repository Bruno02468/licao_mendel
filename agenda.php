<?php
    
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
    
    $hojes = "";
    $outras = "";
    $hoje = date("d/m/Y");
    
    $arquivos = glob($pasta . "*");
    usort($arquivos, function($a, $b) {
        return filectime($a) < filectime($b);
    });
    
    foreach ($arquivos as $file) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
        if ('.qc' === $file) continue;
        if ($pasta . 'index.php' === $file) continue;
        
        $final = "<acronym title='ID de lição: " . basename($file) . "'><table>";
        
        $arquivo = file($file);
        $datacri = filectime($file);
        $pass = date("d/m/Y", $datacri);
        $materia = "<tr><td valign='top'><span class='semiimportante'>Matéria:</span> </td><td valign='top'>" . trim($arquivo[0]) . "<br></td></tr>";
        $passada = "<tr><td valign='top'><span class='semiimportante'>Passada em:</span> </td><td valign='top'>" . $pass . "<br></td></tr>";
        $datastr = $arquivo[1];
        $entrega = strtotime($datastr);
        
        if ($entrega < $agora) {
            //unlink($pasta . $file);
            continue;
        }
        
        $datafin = date("d/m/Y", $entrega); 
        $datapre = "<tr><td valign='top'><span class='semiimportante'>Data de entrega:</span> </td><td valign='top'>" . $datafin . "<br></td></tr>";
        
        $dadosarr = $arquivo;
        unset($dadosarr[0]);
        unset($dadosarr[1]);
        $dados = "<tr><td valign='top'><span class='semiimportante'>Informações:</span> </td><td valign='top'>" . join("<br>", $dadosarr) . "<br></td></tr>";
        
        $final .= $materia . $passada . $datapre . $dados. "</table></acronym><br><br>";
        if ($pass == $hoje) {
            $hojes .= $final;
        } else {
            $outras .= $final;
        }
        
    }
    
    if ($amanhas == "") {
        $amanhas = "<i>Nenhuma lição foi passada hoje.</i><br><br>";
    }
    if ($outras == "") {
        $outras = "<i>Nenhuma lição foi passada em outros dias...</i>";
    }
    
?>
<html>
    <head>
        <title>Lições - <?php echo $nome; ?></title>
        <link rel="stylesheet" href="/stylesheets/dark.css">
        <link rel="stylesheet" href="estilo.css">
        <meta charset="UTF-8">
    </head>
    
    <body>
        <center>
            <h1>Visualização de lições da <?php echo $nome; ?></h1>
            <b><a href="index.php">[Ver lições por data de entrega]</a><br></b>
            <a href="horario.png" target="_blank">Horário da 1ª E</a><br>
            <small>Tudo programado por Bruno Borges Paschoalinoto (1ª E)
            <br>Por um WhatsApp menos confuso :-)</small>
        </center>
        <div class="valeu">
            <input type="button" onclick="vlw()" value="Esta página me ajudou!"> 
            (<span id="vlw"><?php echo trim(file_get_contents("contador.txt")); ?></span>)
        </div>
        <br>
        <br>
        <br>
        <span class="importante">Lições passadas hoje:</span><br><br>
        <?php echo $hojes; ?>
        <hr>
        <span class="importante">Lições passadas em outros dias:</span><br><br>
        <?php echo $outras; ?>

        <script src="javascript.js"></script>
    </body>
</html>
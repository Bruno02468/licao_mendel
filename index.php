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
    }
    
    $agora = time();
    $amanhas = "";
    $outras = "";
    
    if ($handle = opendir($pasta)) {
        while (false !== ($file = readdir($handle))) {
            if ('.' === $file) continue;
            if ('..' === $file) continue;
            if ('.qc' === $file) continue;
            
            $final = "<table>";
            
            $arquivo = file($pasta . $file);
            $materia = "<tr><td valign='top'><span class='semiimportante'>Matéria:</span> </td><td valign='top'>" . trim($arquivo[0]) . ".<br></td></tr>";
            $datastr = $arquivo[1];
            $entrega = strtotime($datastr);
            
            if ($entrega < $agora) {
                unlink($pasta . $file);
                continue;
            }
            
            $datafin = date("d/m/Y", $entrega); 
            $datapre = "<tr><td valign='top'><span class='semiimportante'>Data de entrega:</span> </td><td valign='top'>" . $datafin . ".<br></td></tr>";
            
            $dadosarr = $arquivo;
            unset($dadosarr[0]);
            unset($dadosarr[1]);
            $dados = "<tr><td valign='top'><span class='semiimportante'>Informações:</span> </td><td valign='top'>" . join("<br>", $dadosarr) . "<br></td></tr>";
            
            $final .= $materia . $datapre . $dados. "</table><br><br>";
            
            $amanha = strtotime('+1 day', $agora);
            if ($entrega <= $amanha) {
                $amanhas .= $final;
            } else {
                $outras .= $final;
            }
            
        }
        closedir($handle);
    }
    
    if ($amanhas == "") {
        $amanhas = "<i>Oba! Sem lição pra amanhã!</i><br><br>";
    }
    if ($outras == "") {
        $outras = "<i>Sem outras lições.</i>";
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
            <h1>Visualisação de lições da <?php echo $nome; ?></h1>
            <small>Tudo programado por Bruno Borges Paschoalinoto (1ª E)
            <br>Por um WhatsApp menos confuso :-)</small>
        </center>
        <div class="ir"><small>
            Acesse outra sala (ano + letra): <input type="text" id="sala"><input type="button" onclick="ir()" value="Ir">
        </small></div>
        <br>
        <br>
        <br>
        <span class="importante">Lições para amanhã:</span><br><br>
        <?php echo $amanhas; ?>
        <hr>
        <span class="importante">Lições para outros dias:</span><br><br>
        <?php echo $outras; ?>

        <script src="javascript.js"></script>
    </body>
</html>
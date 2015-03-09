<?php
    
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
            
            $arquivo = file($pasta . $file);
            $materia = "<b>Matéria:</b> " . $arquivo[0] . ".<br>";
            $datastr = $arquivo[1];
            $entrega = strtotime($datastr);
            
            if ($entrega < $agora) continue;
            
            $datafin = date("d/m/Y", $entrega); 
            $datapre = "<b>Data de entrega:</b> " . $datafin . ".<br>";
            
            $dadosarr = $arquivo;
            unset($dadosarr[0]);
            unset($dadosarr[1]);
            $dados = "<b>Informações:</b> <br>" . join("<br>", $dadosarr) . "<br>";
            
            $final = $materia . $datapre . $dados. "<br><br><br>";
            
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
        $amanhas = "<i>Oba! Sem lição pra amanhã!</i>";
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
        Lições para amanhã:<br><br>
        <?php echo $amanhas; ?>
        <br>
        <br>
        <br>
        <br>
        Lições para outros dias:<br><br>
        <?php echo $outras; ?>

        <script src="javascript.js"></script>
    </body>
</html>
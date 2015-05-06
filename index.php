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
            if ('get.php' === $file) continue;
            
            
            $arquivo = file($pasta . $file);
            
            $mat = trim($arquivo[0]);
            $v = "fez";
            $ent = "de entrega";
            $gabaritei = "Gabaritei";
            $classe = "";
            
            if (strpos($mat, "PROVA - ") !== false) {
                $mat = str_replace("PROVA - ", "", $mat);
                $v = "estudou";
                $ent = "da prova";
                $gabaritei = "Estou careca de estudar";
                $classe = " class='prova'";
            }
            
            $final = "<acronym title='ID de lição: " . $file . "'><table$classe>\n";
            
            $materia = "<tr><td valign='top'><span class='semiimportante'>Matéria:</span> </td><td valign='top'>$mat<br></td></tr>\n";
            $datastr = $arquivo[1];
            $entrega = strtotime($datastr);
            
            if ($entrega < $agora) {
                unlink($pasta . $file);
                continue;
            }
            
            $datafin = date("d/m/Y", $entrega); 
            $datapre = "<tr><td valign='top'><span class='semiimportante'>Data $ent:</span> </td><td valign='top'>$datafin<br></td></tr>\n";
            
            $dadosarr = $arquivo;
            unset($dadosarr[0]);
            unset($dadosarr[1]);
            $dados = "<tr><td valign='top'><span class='semiimportante'>Informações:</span> </td><td valign='top'>" . join("<br>", $dadosarr) . "<br></td></tr>\n";
            
            $check = "<tr><td valign='top'><span class='semiimportante'>Já $v?</span> </td><td valign='top'><input type='checkbox' id='$file' onclick='toggleFeita(this.id)'>$gabaritei<br></td></tr>\n";
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
<?php include("extras/top.php") ?>
        <center>
            <h1>Visualização de lições da <?php echo $nome; ?></h1>
            <b><a href="agenda.php">[Ver lições passadas hoje]</a><br></b>
        <?php echo file_get_contents("motd.html"); ?>
        <br>
        <br>
        <span class="importante">Lições para amanhã:</span><br><br>
        <?php echo $amanhas; ?>
        <hr>
        <span class="importante">Lições para outros dias:</span><br><br>
        <?php echo $outras; ?>

        <script src="extras/javascript.js"></script>
    </body>
</html>
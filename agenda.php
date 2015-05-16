<?php
    
    date_default_timezone_set("America/Sao_Paulo");

    function semana($dia) {
        switch ($dia) {
            case "Sunday":
                return "domingo";
            case "Monday":
                return "segunda";
            case "Tuesday":
                return "terça";
            case "Wednesday":
                return "quarta";
            case "Thursday":
                return "quinta";
            case "Friday":
                return "sexta";
            case "Saturday":
                return "sábado";
            default:
                return "<b>erro de dia da semana, wtf</b>";
        }
    }


    $sala = "1E";
    if (isset($_GET['sala'])) {
        $sala = $_GET['sala'];
    }
    
    $nome = $sala[0] . "º " . $sala[1];
    $pasta = "salas/" . $sala . "/";
    if (!file_exists($pasta)) {
        header("Location: http://bruno02468.com/licao/");
        die();
    }
    
    $hojes = "";
    $outras = "";
    $hoje = date("d/m/Y");
    $amanha = strtotime('+1 day', time());
    
    $arquivos = glob($pasta . "*");
    usort($arquivos, function($a, $b) {
        return filectime($a) < filectime($b);
    });
    
    foreach ($arquivos as $file) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
        if ('.qc' === $file) continue;
        if ($pasta . 'index.php' === $file) continue;
        if ($pasta . 'get.php' === $file) continue;
        
        $arquivo = file($file);
        
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
        
        $datacri = filectime($file);
        $pass = date("d/m/Y", $datacri);
        $materia = "<tr><td valign='top'><span class='semiimportante'>Matéria:</span> </td><td valign='top'>$mat<br></td></tr>\n";
        $passada = "<tr><td valign='top'><span class='semiimportante'>Passada em:</span> </td><td valign='top'>$pass<br></td></tr>";
        $datastr = $arquivo[1];
        $entrega = strtotime($datastr);
        
        if ($entrega < time()) {
            unlink($pasta . $file);
            continue;
        }
        
        $datafin = date("d/m/Y", $entrega);
        $semanal = semana(date("l", $entrega));
        if (date("d/m/Y", $amanha) == $datafin) {
            $semanal = "<b>amanhã</b>";
        }
        
        $datapre = "<tr><td valign='top'><span class='semiimportante'>Data $ent:</span> </td><td valign='top'>$datafin ($semanal)<br></td></tr>\n";
        
        $dadosarr = $arquivo;
        unset($dadosarr[0]);
        unset($dadosarr[1]);
        $dados = "<tr><td valign='top'><span class='semiimportante'>Informações:</span> </td><td valign='top'>" . join("<br>", $dadosarr) . "<br></td></tr>\n";
        $final .= $materia;
        
        $check = "<tr><td valign='top'><span class='semiimportante'>Já $v?</span> </td><td valign='top'><input type='checkbox' id='" . basename($file) . "' onclick='toggleFeita(this.id)'>$gabaritei<br></td></tr>\n";
        if ($pass == $hoje) {
            $final .= $datapre . $dados. $check . "</table></acronym><br><br>\n";
            $hojes .= $final;
        } else {
            $final .= $passada . $datapre . $dados . $check . "</table></acronym><br><br>\n";
            $outras .= $final;
        }
        
    }
    
    if ($hojes == "") {
        $hojes = "<i>Nenhuma lição foi passada hoje.</i><br><br>\n";
    }
    if ($outras == "") {
        $outras = "<i>Nenhuma lição foi passada em outros dias...</i>\n";
    }
    
?>
<?php include("extras/top.php"); ?>
<br>
<br>
<span class="importante">Lições passadas hoje:</span><br><br>
<?php echo $hojes; ?>
<hr>
<span class="importante">Lições passadas em outros dias:</span><br><br>
<?php echo $outras; ?>

<script src="extras/javascript.js"></script>
</body>
</html>
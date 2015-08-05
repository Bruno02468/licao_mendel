<html>
    <head>
        <title>Lições do <?php echo $nome; ?></title>
        <link rel="stylesheet" href="/stylesheets/dark.css">
        <link rel="stylesheet" href="extras/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta charset="UTF-8">
    </head>

    <body>
        <?php include_once("extras/ga.php"); ?>
        <audio src="zuera/brasil.mp3" id="hue" type="audio/mpeg" volume="0.3"></audio>
        <div class="valeu">
            <input type="button" onclick="vlw()" value="Valeu, ">
            (<span id="vlw"><?php echo trim(file_get_contents("extras/contador.txt")); ?></span>)<br>
        </div>
        <center>
        <h1>Site de lições do <?php echo $nome; ?></h1>
        <b><a href="agenda.php" id="meulink">[Ver lições passadas hoje]</a></b><br>
        <a href="javascript:void(0)" onclick="horario();">Horário do 1º E</a><br>
        <a href='horario.png' title='Clique para ver o tamanho completo.' target="_blank" id="hor"></a>
        <small>
            Tudo programado por <a target="_blank" href="contato.html">Bruno Borges Paschoalinoto</a> (1º E)<br>
            <small><small><a href="ademir/">[Somente pessoal autorizado]</a></small></small><br>
            <br>Mensagem do dia/mes/ano/éon:<br>
            <div class="mensagem">
                <?php echo formatar(file_get_contents("ademir/atuadores/motd.txt")); ?>
            </div>
        </small>
        </center>
    </body>
</html>

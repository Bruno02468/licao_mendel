<html>
    <head>
        <title>Lições - <?php echo $nome; ?></title>
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
            <input type="button" onclick="vlw()" value="Esta página me ajudou!">
            (<span id="vlw"><?php echo trim(file_get_contents("extras/contador.txt")); ?></span>)
        </div>
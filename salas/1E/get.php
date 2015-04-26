<?php
    $arquivos = glob("*");
    foreach ($arquivos as $file) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
        if ('.qc' === $file) continue;
        if ('index.php' === $file) continue;
        if ('get.php' === $file) continue;
        echo $file . "#";
    }
?>
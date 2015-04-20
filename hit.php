<?php
    
    $contador = "hits.txt";
    $last = file_get_contents($contador);
    $resultado = $last + 1;
    file_put_contents($contador, $resultado);
    echo $resultado;
    
?>
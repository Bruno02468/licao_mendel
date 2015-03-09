<?php
    
    $sala = htmlspecialchars(req('sala'));
    $materia = htmlspecialchars(req('materia'));
    $data = req('data');
    $dados = htmlspecialchars(req('dados'));
    
    function req($str) {
        if (!isset($_GET[$str])) {
            die("Variável GET \"" . $str . "\" necessária para esta requisição.");
        } else {
            return $_GET[$str];
        }
    }
    
    function proximo_nome($sala) {
        $pasta = "../../salas/" . $sala . "/";
        $contador = $pasta . ".qc";
        $last = file_get_contents($contador);
        
        $resultado = $last + 1;
        file_put_contents($contador, $resultado);
        
        return $pasta . $resultado;
    }    

    $arquivo = $materia . "\n" . $data . "\n" . $dados;
    $filename = proximo_nome($sala);
    file_put_contents($filename, $arquivo);
    header("Location: http://bruno02468.com/licao?sala=" . $sala);
    
    //echo "Debug: " . $arquivo . " em " . $filename;
    
?>
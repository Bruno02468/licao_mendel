<?php
    
    $sala = req('sala');
    $id = req('id');
    $dados = req('dados');
    
    function req($str) {
        if (!isset($_GET[$str])) {
            die("Variável GET \"" . $str . "\" necessária para esta requisição.");
        } else {
            return $_GET[$str];
        }
    } 

    $arquivo = "../../salas/" . $sala . "/" . $id;
    
    file_put_contents($arquivo, $dados);
    header("Location: http://bruno02468.com/licao/salas/" . $sala);
    
?>
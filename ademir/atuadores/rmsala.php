<?php

include("../../extras/funcs.php");

include("../auth/authfunctions.php");
require_login("borginhos");

$id = req_post("id");

$dir = "../../salas/$id";
if (strlen($id) !== 2) die("MAIS QUE 2 NÃO PODE");
if (!is_dir($dir)) die("NEM É PASTA");
if ($id[0] == ".") die("PARA DE TROLHAR");

foreach(glob($dir . '/*') as $file) {
    if(is_dir($file)) rrmdir($file);
    else unlink($file);
}
rmdir($dir);


redir("../salas.php");

?>
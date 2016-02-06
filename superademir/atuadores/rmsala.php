<?php

include("../auth/authfunctions.php");
require_login("borginhos");
include("../../extras/funcs.php");

$id = req_post("id");

$dir = "../../salas/$id";
if (strlen($id) !== 2) die("MAIS QUE 2 NÃO PODE");
if (!is_dir($dir)) die("NEM É PASTA");
if ($id[0] == ".") die("PARA DE TROLHAR");

foreach(glob($dir . '/*') as $file) {
    unlink($file);
}
unlink($dir . "/.qc");
rmdir($dir);

unlink("../horarios/hors/$id.horario");

redir("../salas.php");

?>
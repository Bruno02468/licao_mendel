<?php

include("../../extras/database.php");
require_login();
$sala = getUser();
$msg = req_post("msg");

setProperty($sala, "msg", $msg);

if (isset($_POST["admvisao"])) {
    redir("../../sala/$sala");
} else {
    redir("..");
}

?>
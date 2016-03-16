<?php

include("../../extras/database.php");
require_login();
$sala = getUser();

setProperty($sala, "msg", "");

if (isset($_GET["admvisao"])) {
    redir("../../sala/$sala");
} else {
    redir("..");
}

?>
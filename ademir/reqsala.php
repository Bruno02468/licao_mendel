<?php

include("../extras/database.php");
if (isset($_GET["sala"])) {
    require_login($_GET["sala"]);
} else {
    require_login();
}

redir(".");

?>
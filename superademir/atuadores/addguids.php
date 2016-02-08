<?php

include("../../extras/database.php");
require_login("borginhos");

$json = getFullJSON();
foreach ($json as $id => $sala) {
    foreach ($sala["licoes"] as $index => $licao) {
        if (!isset($licao["guid"])) {
            $json[$id]["licoes"][$index]["guid"] = make_guid();
        }
    }
}
setNewJSON($json);

?>
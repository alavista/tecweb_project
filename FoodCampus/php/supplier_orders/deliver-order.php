<?php
    require_once("../database.php");

    if($_GET["id"]) {

        $id = $_GET["id"];
        $sql = "UPDATE ordine SET consegnato = TRUE WHERE IDOrdine = ".$id;
        $result = $GLOBALS["conn"]->query($sql);

        if (!$result === TRUE) {
            http_response_code(400);
        }

    }

?>
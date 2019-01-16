<?php
    require_once("../../php/database.php");
    require_once("db-info.php");

    if(isset($_GET["table"]) && isset($_GET["id"])) {

        $table = $_GET["table"];
        $id = $_GET["id"];

        $sql = "DELETE FROM ".$table." WHERE ".$PRIMARY_KEYS[$table]." = ".$id;
        $result = $GLOBALS["conn"]->query($sql);

        if ($result === TRUE) {
            echo "<div class='alert alert-success' role='alert'>Riga eliminata con successo</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Errore: ".$sql."</div>";
            http_response_code(400);
        }

    }

?>
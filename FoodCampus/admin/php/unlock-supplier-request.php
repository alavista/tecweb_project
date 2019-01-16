<?php
    require_once("../../php/database.php");

    if($_GET["supplier"]) {

        $id_cliente = $_GET["supplier"];
        $sql = "UPDATE fornitore SET bloccato = FALSE WHERE IDFornitore = ".$id_cliente;
        $result = $GLOBALS["conn"]->query($sql);

        if ($result === TRUE) {
            echo "<div class='alert alert-success' role='alert'>Fornitore sbloccato con successo</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Errore: ".$conn->error."</div>";
            http_response_code(400);
        }

    }

?>
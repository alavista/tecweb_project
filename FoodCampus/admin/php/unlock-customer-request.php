<?php
    require_once("../../php/database.php");

    if($_GET["customer"]) {

        $id_cliente = $_GET["customer"];
        $sql = "UPDATE cliente SET bloccato = FALSE WHERE IDCliente = ".$id_cliente;
        $result = $GLOBALS["conn"]->query($sql);

        if ($result === TRUE) {
            echo "<div class='alert alert-success' role='alert'>Cliente sbloccato con successo</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Errore: ".$conn->error."</div>";
            http_response_code(400);
        }

    }

?>
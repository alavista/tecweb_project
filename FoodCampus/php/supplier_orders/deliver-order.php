<?php
    require_once("../database.php");

    if($_GET["id"]) {

        $id = $_GET["id"];

        $stmt = $conn->prepare("UPDATE ordine SET consegnato = 1 WHERE IDOrdine = ?");
        echo "UPDATE ordine SET consegnato = 1 WHERE IDOrdine = ?";
        $stmt->bind_param("i", $IDCliente);
        $IDCliente = $_GET["id"];
        $stmt->execute();

        $stmt = $conn->prepare("SELECT IDCliente FROM ordine WHERE IDOrdine = ?");
        $stmt->bind_param("i", $IDOrdine);
        $IDOrdine = $_GET["id"];
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt = $conn->prepare("INSERT INTO notifica(testo, IDCliente, IDFornitore) VALUES(?, ?, NULL)");
		$stmt->bind_param("si", $testo, $IDCliente);
		$testo = "É partita la consegna del tuo ordine (n.".$id.")";
		$IDCliente = $row["IDCliente"];
		$stmt->execute();

    }

?>
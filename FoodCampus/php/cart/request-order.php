<?php

	require_once("../utilities/direct_login.php");
	require_once("../database.php");
	
	if(isset($_GET['products']) && isset($_GET['quantities']) && isset($_GET['customer']) && isset($_GET['payment']) && isset($_GET['price']) && isset($_GET['hour']) && isset($_GET['minute'])) {
		$products = explode(",", $_GET['products']);
		$quantities = explode(",", $_GET['quantities']);
		for($i=0; $i<count($products); $i++) {
			$ordered_prod[$products[$i]] = $quantities[$i];
		}
		$IDCliente ="";
		$stmt = $conn->prepare("INSERT INTO ordine(IDCliente, tipo_pagamento, prezzo, orario_consegna_ora, orario_consegna_minuti) VALUES(?, ?, ?, ?, ?)");
		$stmt->bind_param("isdii", $IDCliente, $payment_method, $price, $time_hour, $time_minute);
		$IDCliente = $_GET["customer"];
		$payment_method = $_GET["payment"];
		$price = $_GET["price"];
		$time_hour = $_GET["hour"];
		$time_minute = $_GET["minute"];
		$stmt->execute();

		$id = mysqli_insert_id($conn);

		$stmt = $conn->prepare("INSERT INTO prodotto_in_ordine(IDOrdine, IDProdotto, quantita) VALUES(?, ?, ?)");
		$stmt->bind_param("iii", $IDOrdine, $IDProdotto, $quantity);

		$IDOrdine = $id;

		foreach($ordered_prod as $prod => $quant) {
			$IDProdotto = $prod;
			$quantity = $quant;
			$stmt->execute();
		}

		$stmt = $conn->prepare("INSERT INTO notifica(testo, IDCliente) VALUES(?, ?)");
		$stmt->bind_param("si", $testo, $IDCliente);
		$testo = "Hai ricevuto un nuovo ordine (".number_format($price, 2)." €)";
		$IDCliente = $_GET['customer'];
		$stmt->execute();
	}
?>
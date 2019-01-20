<?php

	require_once("../utilities/direct_login.php");
	require_once("../database.php");
	
	if(isset($_GET['products']) && isset($_GET['quantities']) && isset($_GET['customer']) && isset($_GET['supplier']) && isset($_GET['payment']) && isset($_GET['hour']) && isset($_GET['minute'])) {

		unset($_SESSION['cart']);
		unset($_SESSION["cart_filled"]);

		$products = explode(",", $_GET['products']);
		$quantities = explode(",", $_GET['quantities']);

	    $stmt = $conn->prepare("SELECT costo FROM prodotto WHERE IDProdotto = ?");
	    $stmt->bind_param("i", $pid);
		
	    $tot_price = 0;
		for($i=0; $i<count($products); $i++) {
			$ordered_prod[$products[$i]] = $quantities[$i];
			$pid = $products[$i];
			$stmt->execute();
			$result = $stmt->get_result();
            if ($result->num_rows > 0) {
            	$row = $result->fetch_assoc();
				$prod_price = $row['costo'];
            }
			$tot_price += $prod_price * $quantities[$i];
		}

		if($stmt = $conn->prepare("INSERT INTO ordine(IDCliente, tipo_pagamento, prezzo, orario_consegna_ora, orario_consegna_minuti, consegnato) VALUES(?, ?, ?, ?, ?, FALSE)")) {
			$stmt->bind_param("isdii", $IDCliente, $payment_method, $price, $time_hour, $time_minute);
			$IDCliente = $_GET["customer"];
			$payment_method = $_GET["payment"];
			$price = $tot_price;
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

			$stmt = $conn->prepare("INSERT INTO notifica(testo, IDFornitore, IDCliente) VALUES(?, ?, NULL)");
			$stmt->bind_param("si", $testo, $IDFornitore);
			$testo = "Hai ricevuto un nuovo ordine (".number_format($price, 2)." €)";
			$IDFornitore = $_GET['supplier'];
			$stmt->execute();
		} else {
			var_dump($conn->error_list);
		}
	}
?>
<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/tecweb_project/FoodCampus/php/utilities/secure_session.php");
	require_once("../database.php");
	require_once("../utilities/direct_login.php");

	if(isset($_GET["product"]) && isset($_GET["quantity"]) && is_numeric($_GET["quantity"])) {
		$id = $_GET["product"];
		$_SESSION["cart"][$id] = $_GET["quantity"];

		if(isUserLogged($conn)) {
	  		$stmt = $conn->prepare("UPDATE prodotto_in_carrello SET quantita = ? WHERE IDCliente = ? && IDProdotto = ?");
	  		$stmt->bind_param("iii", $quantity, $user, $product);
	  		$user = $_SESSION['user_id'];
	  		$product = $_GET["product"];
	  		$quantity = $_GET["quantity"];
			$stmt->execute();
	  	}
	}

?>
<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/tecweb_project/FoodCampus/php/utilities/secure_session.php");
	require_once("../database.php");
	require_once("../utilities/direct_login.php");
	
	if(isset($_GET["product_added"]) && isset($_GET["quantity"])) {
		$id = $_GET["product_added"];
		if(!isset($_SESSION["cart_filled"]) || !isset($_SESSION["cart"])) {
			$_SESSION["cart_filled"] = "true";
			$_SESSION["cart"] = array();
		}
		if(!isset($_SESSION["cart"][$id])) {
			$_SESSION["cart"][$id] = intval($_GET["quantity"]);
			if(isUserLogged($conn)) {
		  		$stmt = $conn->prepare("INSERT INTO prodotto_in_carrello (IDCliente, IDProdotto, quantita) VALUES(?, ? ,?)");
		  		$stmt->bind_param("iii", $user, $product, $quantity);
		  		$user = $_SESSION['user_id'];
		  		$product = $_GET["product_added"];
		  		$quantity = $_GET["quantity"];
				$stmt->execute();
		  	}
		} else {
			$_SESSION["cart"][$id] += $_GET["quantity"];
			if(isUserLogged($conn)) {
		  		$stmt = $conn->prepare("UPDATE prodotto_in_carrello SET quantita = ? WHERE IDCliente = ? && IDProdotto = ?");
		  		$stmt->bind_param("iii", $quantity, $user, $product);
		  		$user = $_SESSION['user_id'];
		  		$product = $_GET["product_added"];
		  		$quantity = $_SESSION["cart"][$id];
				$stmt->execute();
	  		}
	  	}

	  	

	  	$num_prod = 0;
	  	foreach ($_SESSION["cart"] as $value) {
	  		$num_prod += $value;
	  	}
	  	$return = array("num_prod" => $num_prod);
		echo json_encode($return);
	}
?>
<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/tecweb_project/FoodCampus/php/utilities/secure_session.php");
	require_once("../database.php");
	require_once("../utilities/direct_login.php");
	
	if(isset($_GET["product_removed"])) {
		$id = $_GET["product_removed"];
		unset($_SESSION["cart"][$id]);
		if(isUserLogged($conn)) {
			$conn2 = new mysqli("localhost", "root", "", "foodcampus");
			if ($conn2->connect_errno) {
				die("Failed to connect to MySQL: (" . $conn2->connect_errno . ") " . $conn2->connect_error);
			}
	  		$stmt = $conn2->prepare("DELETE FROM prodotto_in_carrello WHERE IDCliente = ? && IDProdotto = ?");
	  		$stmt->bind_param("ii", $user, $product);
	  		$user = $_SESSION['user_id'];
	  		$product = $_GET["product_removed"];
			$stmt->execute();
	  	}
	}

	$num_prod = 0;
  	foreach ($_SESSION["cart"] as $value) {
  		$num_prod += $value;
  	}

	if($num_prod == 0) {
		unset($_SESSION["cart"]);
		unset($_SESSION["cart_filled"]);
		$return = array("empty_cart" => true);
	} else {
		$return = array("empty_cart" => false);
	}
	echo json_encode($return);
	
?>
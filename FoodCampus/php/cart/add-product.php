<?php
	session_start();
	if(isset($_GET["product_added"]) && isset($_GET["quantity"])) {
		$id = $_GET["product_added"];
		if(!isset($_SESSION["cart_filled"])) {
			$_SESSION["cart_filled"] = "true";
			$_SESSION["cart"] = array();
			$_SESSION["cart"][$id] = $_GET["quantity"];
		} else {
			$_SESSION["cart"][$id] += $_GET["quantity"];
	  	}

	  	$num_prod = 0;
	  	foreach ($_SESSION["cart"] as $value) {
	  		$num_prod += $value;
	  	}
	  	$return = array("num_prod" => $num_prod);
		echo json_encode($return);
	}
?>
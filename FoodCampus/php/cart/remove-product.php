<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once "$root/tecweb_project/FoodCampus/php/utilities/secure_session.php";
	sec_session_start();
	
	if(isset($_GET["product_removed"])) {
		$id = $_GET["product_removed"];
		unset($_SESSION["cart"][$id]);
		echo "fatto";
	}
	
?>
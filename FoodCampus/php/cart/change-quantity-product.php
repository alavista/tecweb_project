<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once "$root/tecweb_project/FoodCampus/php/utilities/secure_session.php";
	sec_session_start();

	if(isset($_GET["product"]) && isset($_GET["quantity"])) {
		$id = $_GET["product"];
		$_SESSION["cart"][$id] = $_GET["quantity"];
	}

?>
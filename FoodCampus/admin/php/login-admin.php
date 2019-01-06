<?php
	
	require_once("config.php");

	if(isset($_POST["submit"])) {
		if(isset($_POST["name"]) && isset($_POST["password"])) {
			$admin = $_POST["name"];
			$pwd = $_POST["password"];
			if($admin == ADMIN && $pwd == ADMIN_PASSWORD) {
				session_start();
				$_SESSION["admin"] = "OK";
				header("Location: ../manage-database.php");
			} else {
				header("Location: ../index.php");
			}
		}
	}

?>
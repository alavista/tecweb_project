<?php
	
	if(isset($_GET["product_removed"])) {
		$_SESSION["cart"] = str_replace($_GET["product_removed"], $replace, $_SESSION["cart"]);
	}
	
?>
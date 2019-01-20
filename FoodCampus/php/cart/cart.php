<?php
	require_once("../utilities/direct_login.php");
	require_once("../database.php");

	$product_list = "";
	if(!isset($_SESSION) || isset($_SESSION["cart_filled"])) {
        foreach ($_SESSION["cart"] as $key => $value) {
            $product_list .= $key.","; 
        }
    }

    $product_list = substr($product_list, 0, -1);
    $stmt = $conn->prepare("SELECT p.IDProdotto as pid, p.nome as pnome, p.costo as costo, f.nome as fnome
                                    FROM prodotto as p, fornitore as f
                                    WHERE p.IDFornitore = f.IDFornitore
                                    AND f.bloccato = 0 
                                    AND f.abilitato = 1
                                    AND p.IDProdotto in(".$product_list.")");
	$stmt->execute();
	$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="it-IT">
<head>
	<title>Ricerca Prodotti</title>
	<metacharset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Notify -->
	<?php require_once '../navbar/filesForNotify.html'; ?>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<!--Font awesome-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" title="stylesheet" href="../navbar/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="cart.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="../../css/utilities.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="../footer/footer.css">
</head>
<body>
	<?php require_once '../navbar/navbar.php';?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xs-12 col-md-10 col-lg-8">
			<h1 class="clientStartAfterNavbar">Carrello</h1>       
				<table class="table table-striped">
					<tbody>
						<?php

							while ($row = $result->fetch_assoc()) {
								echo "<tr id='".$row['pid']."''><td>".$row['pnome']."</td><td>".$row['costo']."</td><td>".$row['fnome']."</td><td><input class='quantity-input' type='number' name='quantity' min='1' step='1' product=".$row['pid']." value='".$_SESSION['cart'][$row['pid']]."'></td><td><button type='button' value=".$row['pid']." class='btn btn-danger remove-product'>Rimuovi</button></td></tr>";
							}

						?>
					</tbody>
				</table>
				<a role='button' href="buy.php" class='btn btn-success buy-button'>Acquista</a>
			</div>
		</div>
	</div>
	<?php require_once "../footer/footer.html"; ?>
</body>
</html>

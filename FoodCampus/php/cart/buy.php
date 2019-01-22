<?php
	require_once("../utilities/direct_login.php");
	require_once("../database.php");

	if(isUserLogged($conn)) {
		$product_list = "";
		if(isset($_SESSION["cart_filled"]) && isset($_SESSION["cart"])) {

	        foreach ($_SESSION["cart"] as $key => $value) {
	            $product_list .= $key.","; 
	        }	    

		    $product_list = substr($product_list, 0, -1);
		    $stmt = $conn->prepare("SELECT p.IDProdotto as pid, p.nome as pnome, p.costo as costo, f.IDFornitore as fid, f.nome as fnome
		        FROM prodotto as p, fornitore as f
		        WHERE p.IDFornitore = f.IDFornitore
		        AND f.bloccato = 0 
		        AND f.abilitato = 1
		        AND p.IDProdotto in(".$product_list.") ORDER BY fnome");
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

	<script src="buy.js"></script>

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
				<div style="display: none" id="IDCustomer" value="<?php echo $_SESSION['user_id']; ?>"></div>
				<h1 class="clientStartAfterNavbar">Ordini</h1>       
				
				<?php
					$supplier = 0;
					$num_order = 1;
					$tot_price = 0;
					while ($row = $result->fetch_assoc()) {
						$tot_price += $row['costo']*$_SESSION['cart'][$row['pid']];
						if($supplier == 0) {
							$supplier = $row['fid'];
							echo "<table id='".$supplier."' class='table table-striped order-table'><tbody><thead><tr><th>#".$num_order." ".$row['fnome']."</th></tr></thead>";
						} else {
							if($row['fid'] != $supplier) {
								$num_order++;
								$supplier = $row['fid'];
								echo "</tbody></table><br/><table id='".$supplier."' class='table table-striped order-table'><tbody>";
								echo "<thead><tr><th>#".$num_order." ".$row['fnome']."</th></tr></thead>";
							}
						}
						echo "<tr id=".$row['pid']." class='product-row'><td>".$row['pnome']."</td><td >".$row['costo']." €</td><td class='quantity' value=".$_SESSION['cart'][$row['pid']].">x".$_SESSION['cart'][$row['pid']]."</td></tr>";
					}
					echo "</tbody></table>";
					echo "<p value='".number_format($tot_price, 2)."'>Prezzo totale: ".number_format($tot_price, 2)." €</p>"
				?>

				<form>

					<label>Seleziona metodo di pagamento:</label>
					<div class="form-check">
						<input class="form-check-input" type="radio" id="payment-method1" name="payment-method" value="Contrassegno" checked>
						<label class="form-check-label" for="payment-method1">
						Contrassegno
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" id="payment-method2" name="payment-method" value="Carta di credito">
						<label class="form-check-label" for="payment-method2">
						Carta di credito
						</label>
					</div>
					<label for="delivery-place">Seleziona il luogo di consegna:</label>
   					<select class="form-control col-lg-5 col-md-7" name="delivery-place" id="delivery-place">
					  <option value="Ingresso+Campus+via+Macchiavelli" selected>Ingresso Campus via Macchiavelli</option>
					  <option value="Ingresso+Campus+via+Pavese">Ingresso Campus via Pavese</option>
					</select>
					<label for="delivery-time">Seleziona l'orario di consegna:&nbsp;&nbsp;</label><input class="form-control col-lg-2 col-md-2" type="time" id="delivery-time" name="delivery-time" required><br/><br/>
					<input role="button" type="submit" class='btn btn-success buy-button' value='Acquista'></a>
				</form>
					
				<div id="result-order-request"></div>

			</div>
		</div>
	</div>
	<?php require_once "../footer/footer.html"; ?>
</body>
</html>

<?php 
		} else {
			header("location: ../home/home.php");
		}
	} else {
		header("location: ../login/login.php");
	}
?>
<?php
	
	session_start();
	if(!isset($_SESSION["admin"])) {
		header("Location: index.html");
	}

	$db_table = array("Clienti"=>"cliente", "Fornitori"=>"fornitore", "Categorie"=>"categoria", "Prodotti"=>"prodotto", "Ordini"=>"ordine", "Recensioni"=>"recensione", "Notifiche"=>"notifica");

?>

<!DOCTYPE html>
<html lang="it-IT">
	<head>
		<title>Gestione Database</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<!--Font awesome-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
		<script src="index.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<div class="container">
		
			<?php include_once("navtab.php") ?>

			<div id="manager-db" class="row">

				<div class="hidden-sm-down col-md-2">
					<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
					  	<div class="btn-group-vertical" role="group" aria-label="First group">
				            <?php
				            	foreach($db_table as $key => $value) {
					                echo "<button type='button' class='btn btn-primary table-request-button' value='".$value."'/>".$key."</button>";
				            	}
				            ?>
			        	</div>
			    	</div>
			    </div>
		        <div id="result" class="col-sm-12 col-md-10"></div>
	        </div>

			</div>
		</div>
	</body>

</html>
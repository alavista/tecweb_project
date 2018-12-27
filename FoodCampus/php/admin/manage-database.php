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

			<div class="row">

			<div id="manager-db">
				<nav class="col-md-2 d-none d-md-block bg-light sidebar">
		          <div class="sidebar-sticky">
		            <ul class="nav flex-column">
		            <?php
		            	foreach($db_table as $key => $value) {
		            		echo "<li class='nav-item'>"
			                ."<a class='nav-link active' href='#manage-database_".$value."'>"
			                .$key
			                ."</a></li>";
		            	}
		            ?>
		            </ul>
		          </div>
		        </nav>
	        </div>

			</div>
		</div>
	</body>

</html>
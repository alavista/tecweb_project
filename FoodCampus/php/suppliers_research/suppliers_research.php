<?php

require_once "../database.php";
require_once "../utilities/direct_login.php";


if ($_SERVER['REQUEST_METHOD'] == "POST") {

	if (!isset($_POST["request"]) || empty($_POST["request"])) {
		die("patata");
	} else {
		die("fanculo");
	}
	die("zsdkasld");

}

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
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<!--Font awesome-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

	<script src="suppliers_research.js"></script>

	<link rel="stylesheet" type="text/css" title="stylesheet" href="../../css/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="suppliers_research.css">
</head>

<body>
	<?php require_once '../navbar.php';?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div id="mainForm">
					<h1>RICERCA PRODOTTI</h1>
					<noscript>
						<div class='alert alert-danger' style='margin-top: 8px;'>
							<strong>ATTENZIONE:</strong> Questa pagina NON funziona senza JavaScript.
							Per favore, riabilita JavaScript nel tuo Browser e ricarica la pagina.
						</div>
					</noscript>
					<div class="row">
						<div class="col">
							<div id="categoryField">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

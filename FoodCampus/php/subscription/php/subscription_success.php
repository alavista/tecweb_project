<!DOCTYPE html>
<html lang="it-IT">
<head>
	<title>Iscrizione completata</title>
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
	<script src="../../../jquery/jquery-3.2.1.min.js"> </script>

	<link rel="stylesheet" type="text/css" title="stylesheet" href="/tecweb_project/FoodCampus/css/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="/tecweb_project/FoodCampus/php/subscription/css/subscription_success.css">
</head>

<body>
	<?php require_once '../../navbar.php';?>
	<div class="container">
		<div class="row">
			<div class="container col-6 jumbotron mx-auto" id="maindiv">
				<div class="col-10 mx-auto">
				<h1 class="text-primary" id="first_title">Account creato!</h1>
				<p class="info">Congratulazioni, account creato correttamente!</p>
				<p class="info">Ora puoi effettuare acquisti e scrivere recensioni!</p>
				<p class="info">Puoi modificare le tue informazioni personali in qualsiasi momento nella pagina del tuo profilo.</p>
				<div class="row justify-content-center">
					<button type="submit" id="continuebtn" class="btn btn-primary btn-lg" onclick="location.href = '../../home.php';">Continua</button>
				</div>
			</div>
			</div>
		</div>
	</div>
</body>

</html>

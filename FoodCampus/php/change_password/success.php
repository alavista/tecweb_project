<!DOCTYPE html>
<html lang="it-IT">
<head>
	<title>Password aggiornata</title>
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
	<script src="../../jquery/jquery-3.2.1.min.js"> </script>

	<link rel="stylesheet" type="text/css" title="stylesheet" href="../navbar/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="success.css">
</head>

<body>
	<?php require_once '../navbar/navbar.php';?>
	<div class="container">
		<div class="row">
			<div class="container col-6 jumbotron mx-auto" id="maindiv">
				<div class="col-10 mx-auto">
				<h1 class="text-primary" id="first_title">Password aggiornata!</h1>
				<p class="info">Congratulazioni, password aggiornata correttamente!</p>
				<p class="info">Ora puoi procedere con il login!</p>
				<div class="row justify-content-center">
					<button type="submit" id="continuebtn" class="btn btn-primary btn-lg" onclick="location.href = '../Login/login.php';">Vai al Login</button>
				</div>
				<noscript>
					<div class='alert alert-warning' style='margin-top: 8px;'>
						<strong>ATTENZIONE:</strong> Questa pagina potrebbe non funzionare correttamente senza JavaScript.
						Per favore, riabilita JavaScript nel tuo Browser e ricarica la pagina.
					</div>
				</noscript>
			</div>
			</div>
		</div>
	</div>
</body>

</html>

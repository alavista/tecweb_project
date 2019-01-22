<?php
require_once "../../database.php";
require_once "../../utilities/direct_login.php";

// Redirect to home page
function redirect($conn, $page) {
	header("Location: $page");
	mysqli_close($conn);
	exit();
}

// If user is already logged in, redirect
if (!isUserLogged($conn)) {
	redirect($conn, "../../home/home.php");
}
?>
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

	<link rel="stylesheet" type="text/css" title="stylesheet" href="../../footer/footer.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="../../navbar/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="../../subscription/css/subscription_success.css">
</head>

<body>
	<?php require_once '../../navbar/navbar.php';?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6 jumbotron" id="maindiv">
				<div class="col-10 mx-auto">
				<h1 class="text-primary" id="first_title">Account creato!</h1>
				<p class="info">Congratulazioni, account creato correttamente!</p>
				<?php
					if ($_SESSION['user_type'] === "Fornitore") {
						echo "<p class='info'><strong style='color: red'>ATTENZIONE:</strong> devi attendere che il tuo account venga abilitato per poter essere visibile nel nostro sito.</p>";
						echo "<p class='info'>Riceverai una notifica ed una email appena il tuo account verr&agrave; abilitato.</p>";
						echo "<p class='info'>Intanto, puoi visitare la pagina del tuo profilo per aggiungere i prodotti che desideri vendere!</p>";
					} else {
						echo "<p class='info'>Ora puoi effettuare acquisti e scrivere recensioni!</p>";
					}
				?>
				<p class="info">Puoi modificare le tue informazioni personali in qualsiasi momento nella pagina del tuo profilo.</p>
				<div class="row justify-content-center">
					<button type="submit" id="continuebtn" class="btn btn-primary btn-lg" onclick="location.href = '../../home/home.php';">Continua</button>
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
	<?php
		require_once "../../cookie/cookie.php";
		require_once "../../footer/footer.html";
	?>
</body>
</html>

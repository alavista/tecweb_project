<?php

$emailError = "";
$passwordError = "";
$GLOBALS["sqlError"] = "";
$GLOBALS["sqlWarning"] = "";

$cookie_user_email = "user_email";
$cookie_user_password = "user_password";

require_once "../database.php";
require_once "login_functions.php";

sec_session_start(); // usiamo la nostra funzione per avviare una sessione php sicura

//Redirect to home page
function redirect($conn) {
	header("Location: ../home.php");
	mysqli_close($conn);
	exit();
}

function cookieDirectLogin($email, $user_password, $conn) {

	$query = "SELECT IDCliente, password, salt, bloccato FROM cliente WHERE email = ?";

	if ($stmt = $conn->prepare($query)) {
	   $stmt->bind_param('s', $email);
	   // Esegui la query ottenuta.
	   if (!$stmt->execute()) {
		   $GLOBALS["sqlError"] = "Errore durante l'invio dei dati";
		   return;
	   }

   } else {
	   $GLOBALS["sqlError"] = $conn->error;
	   return;
   }

   $stmt->store_result();
   $stmt->bind_result($user_id, $db_password, $salt, $blocked);
   $stmt->fetch();

   if (isset($blocked) && $blocked !== 0) {
	   $GLOBALS["sqlError"] = "Questo utente è stato bloccato, impossibile accedere.";
	   return;
   }

	if ($stmt->num_rows > 0) {
		$user_password = hash('sha512', $user_password.$salt); // codifica la password usando una chiave univoca.
		if ($user_password == $db_password) {
			redirect($conn);
		}
	} else {

		$query = "SELECT IDFornitore, password, salt, bloccato FROM fornitore WHERE email = ?";

		if ($stmt = $conn->prepare($query)) {
		   $stmt->bind_param('s', $email);
		   // Esegui la query ottenuta.
		   if (!$stmt->execute()) {
			   $GLOBALS["sqlError"] = "Errore durante l'invio dei dati";
			   return;
		   }

	   } else {
		   $GLOBALS["sqlError"] = $conn->error;
		   return;
	   }

	   $stmt->store_result();
	   $stmt->bind_result($user_id, $db_password, $salt, $blocked);
	   $stmt->fetch();

	   if (isset($blocked) && $blocked !== 0) {
		   $GLOBALS["sqlError"] = "Questo utente è stato bloccato, impossibile accedere.";
		   return;
	   }

		if ($stmt->num_rows > 0) {
			$user_password = hash('sha512', $user_password.$salt); // codifica la password usando una chiave univoca.
			if ($user_password == $db_password) {
				redirect($conn);
			}
		}
	}
}

//Check if user has currently cookies or session variables set
if (isset($_COOKIE[$cookie_user_email]) && isset($_COOKIE[$cookie_user_password])) {
	cookieDirectLogin($_COOKIE[$cookie_user_email], $_COOKIE[$cookie_user_password], $conn);
} else if (login_check($conn)) {
	redirect($conn);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	if (!isset($_POST["p"]) || empty($_POST["p"])) {
		$passwordError = "Inserire una password";
	}

	if (isset($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

		if (isset($_POST["p"]) && !empty($_POST["p"])) {
			switch (login($_POST["email"], $_POST["p"], $conn)) {

				case -2:
					// user blocked due to its many accesses
				break;

				case -1:
					$emailError = "Indirizzo email o password non corretti";
				break;

				case 0:
					$emailError = "Nessun utente registrato con questo indirizzo email";
				break;

				case 1:
					// login successfull
					if (isset($_POST["keepmelogged"]) && !empty($_POST["keepmelogged"])) {
						setcookie($cookie_user_email, $_POST["email"], time() + (86400 * 365 * 5), "/"); // 5 years
						setcookie($cookie_user_password, $_POST["p"], time() + (86400 * 365 * 5), "/"); // 5 years
					}

					redirect($conn);

				break;
			}
		}

	} else {
		$emailError = "Inserire un indirizzo email valido";
	}

}
?>
<!DOCTYPE html>
<html lang="it-IT">
<head>
	<title>Login</title>
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

	<script src="../../js/utilities/sha512.js"></script>
	<script src="../../js/utilities/form_password_encoder.js"></script>
	<script src="login.js"></script>

	<link rel="stylesheet" type="text/css" title="stylesheet" href="../../css/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="login.css">
</head>

<body>
	<?php require_once '../navbar.php';?>
	<div class="container">
		<div class="row">
			<div class="col"></div>
			<div class="col-6 jumbotron mx-auto" id="loginform">
				<h1 class="form-title">Login</h1>
				<form action="login.php" method="post">
					<div class="form-group">
						<label for="email">Indirizzo Email:</label>
						<input type="email" class="form-control" id="email"  placeholder="Inserisci email" name="email">
						<?php
							if(strlen($emailError) !== 0) {
								echo("<div class='alert alert-danger' style='margin-top: 8px;'>$emailError</div>");
							}
						?>
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" class="form-control" id="password"  placeholder="Inserisci password" name="password">
						<?php
							if(strlen($passwordError) !== 0) {
								echo("<div class='alert alert-danger' style='margin-top: 8px;'>$passwordError</div>");
							}
						?>
					</div>
					<a href="#">Password dimenticata?</a>
					<div id="remember_me" name="remember_me" class="form-group form-check">
						<label class="form-check-label">
							<input class="form-check-input" type="checkbox" name="keepmelogged"> Rimani collegato
						</label>
					</div>
					<br/>
					<div class="d-flex justify-content-center">
						<button type="submit" id="loginbtn" class="btn btn-primary btn-lg">Accedi</button>
					</div>
					<?php
						if(strlen($GLOBALS["sqlError"]) !== 0) {
							echo("<div class='alert alert-danger' style='margin-top: 8px;'>".$GLOBALS["sqlError"]."</div>");
						}
						if(strlen($GLOBALS["sqlWarning"]) !== 0) {
							echo("<div class='alert alert-warning' style='margin-top: 8px;'>".$GLOBALS["sqlWarning"]."</div>");
						}
					?>
				</form>
				<br/>
				<div class="d-flex justify-content-center">
					<a class="align-middle" href="../subscription/php/subscription.php">Non hai un account? Clicca qui per iscriverti!</a>
				</div>
			</div>
			<div class="col"></div>
		</div>
	</div>
</body>

</html>

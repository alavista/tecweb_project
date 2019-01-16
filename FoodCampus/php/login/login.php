<?php

$checkClientError="";
$emailError = "";
$passwordError = "";

require_once "../database.php";
require_once "login_functions.php";
require_once "../utilities/direct_login.php";

if (isSessionForReview()) {
	if (strcmp($_SESSION["validReview"], "yes") == 0) {
		$_SESSION["validReview"] = "nearly";
	} else if (strcmp($_SESSION["validReview"], "nearly") == 0) {
		$_SESSION["validReview"] = "no";
	} else if (strcmp($_SESSION["validReview"], "no") == 0) {
		unsetSessionForReview();
	}
}

//Redirect to supplier page
function redirectToSupplier($conn, $idSupplier) {
	header("Location: /tecweb_project/FoodCampus/php/user/suppliers/php/supplier.php?id=".$idSupplier);
	mysqli_close($conn);
	exit();
}

//Redirect to home page
function redirectToHome($conn) {
	header("Location: ../home/home.php");
	mysqli_close($conn);
	exit();
}


if (isUserLogged($conn)) {
	redirectToHome($conn);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	if (!isset($_POST["p"]) || empty($_POST["p"])) {
		if (!isset($_POST["password"]) || empty($_POST["password"])) {
			$passwordError = "Inserire una password";
		} else {
			$password = $_POST["password"];
		}
	} else {
		$password = $_POST["p"];
	}

	if (isset($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

		if (isset($password) && !empty($password)) {

			if (login($conn, $_POST["email"], $password, $emailError)) {
				// login successfull
				if (isset($_POST["rimanicollegato"]) && !empty($_POST["rimanicollegato"])) {
					setcookie($GLOBALS["cookie_user_id"], $GLOBALS["user_id"], time() + (86400 * 365 * 5), "/"); // 5 years
					setcookie($GLOBALS["cookie_user_email"], $_POST["email"], time() + (86400 * 365 * 5), "/"); // 5 years
					setcookie($GLOBALS["cookie_user_password"], $password, time() + (86400 * 365 * 5), "/"); // 5 years
					setcookie($GLOBALS["cookie_user_type"], $GLOBALS["user_type"], time() + (86400 * 365 * 5), "/"); // 5 years
				}
				if (isSessionForReview()) {
					$idSupplier = $_SESSION["idSupplierForReview"];
					unsetSessionForReview();
					redirectToSupplier($conn, $idSupplier);
				} else {
					redirectToHome($conn);
				}
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
	<!-- Plugin JQuery for sessions-->
	<script src="../../jquery/jquery.session.js"></script>
	<!--Font awesome-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

	<script src="../../js/utilities/sha512.js"></script>
	<script src="../../js/utilities/form_password_encoder.js"></script>
	<script src="login.js"></script>

	<link rel="stylesheet" type="text/css" title="stylesheet" href="../navbar/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="login.css">
</head>

<body>
	<?php require_once '../navbar/navbar.php';?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6 jumbotron" id="loginform">
				<h1 class="form-title">Login</h1>
				<form action="login.php" method="post">
					<div class="form-group">
						<label for="email">Indirizzo Email:</label>
						<input type="email" required class="form-control" id="email"  placeholder="Inserisci email" name="email">
						<?php
							if(strlen($emailError) !== 0) {
								echo("<div class='alert alert-danger' style='margin-top: 8px;'>$emailError</div>");
							}
						?>
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" class="form-control" required id="password"  placeholder="Inserisci password" name="password">
						<?php
							if(strlen($passwordError) !== 0) {
								echo("<div class='alert alert-danger' style='margin-top: 8px;'>$passwordError</div>");
							}
						?>
					</div>
					<a href="../change_password/change_password.php">Password dimenticata?</a>
					<div id="remember_me" class="form-group form-check">
						<input class="form-check-input" type="checkbox" id="rimanicollegato" name="rimanicollegato">
						<label for="rimanicollegato">Rimani collegato</label>
					</div>
					<br/>
					<div class="d-flex justify-content-center form-group">
						<button type="submit" id="loginbtn" class="btn btn-primary btn-lg">Accedi</button>
					</div>
					<noscript>
						<div class='alert alert-warning' style='margin-top: 8px;'>
							<strong>ATTENZIONE:</strong> Questa pagina potrebbe non funzionare correttamente senza JavaScript.
							Per favore, riabilita JavaScript nel tuo Browser e ricarica la pagina.
						</div>
					</noscript>
					<?php
						if(strlen($GLOBALS["sqlError"]) !== 0) {
							echo("<div class='alert alert-danger' style='margin-top: 8px;'>".$GLOBALS["sqlError"]."</div>");
						}
						if(strlen($GLOBALS["sqlWarning"]) !== 0) {
							echo("<div class='alert alert-warning' style='margin-top: 8px;'>".$GLOBALS["sqlWarning"]."</div>");
						}
						if ($GLOBALS["user_banned"]) {
							echo("<div class='alert alert-danger' style='margin-top: 8px;'>Questo utente è stato bannato, impossibile accedere</div>");
						}
					?>
				</form>
				<br/>
				<div class="d-flex justify-content-center">
					<a class="align-middle" href="../subscription/php/subscription.php">Non hai un account? Clicca qui per iscriverti!</a>
				</div>
			</div>
		</div>
	</div>
</body>

</html>

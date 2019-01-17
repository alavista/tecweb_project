<?php

$errors = false;

$passwordError = "";
$confirmPasswordError = "";

$slqError = "";
$queryErrors = array();

$conn = new mysqli("localhost", "root", "", "foodcampus");
// Se ti stai connettendo usando il protocollo TCP/IP, invece di usare un socket UNIX, ricordati di aggiungere il parametro corrispondente al numero di porta.

if ($conn->connect_errno) {
	die("Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error);
}

require_once "../login/login_functions.php";
require_once "../utilities/direct_login.php";

//Redirect to home page
function redirectToHome($conn) {
	header("Location: ../home.php");
	mysqli_close($conn);
	exit();
}

// If user is already logged in, redirect
if (isUserLogged($conn) || !isset($_SESSION['email_with_code']) || !isset($_SESSION['user_type_with_code'])) {
	redirectToHome($conn);
}

function deleteUserRequests($conn) {

	$query = "DELETE FROM tentativi_inserimento_codice WHERE email = ?";

	if ($stmt = $conn->prepare($query)) {
		$stmt->bind_param('s', $_SESSION['email_with_code']);

		// Esegui la query ottenuta.
		if ($stmt->execute()) {
			// code...
		} else {
			die($stmt->error);
		}
	} else {
		die($conn->error);
	}

	$query = "DELETE FROM richieste_cambio_password WHERE email = ?";

	if ($stmt = $conn->prepare($query)) {
		$stmt->bind_param('s', $_SESSION['email_with_code']);

		// Esegui la query ottenuta.
		if ($stmt->execute()) {
			// code...
		} else {
			die($stmt->error);
		}
	} else {
		die($conn->error);
	}

}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	if (!isset($_POST["p"]) || empty($_POST["p"])) {
		if (!isset($_POST["pswd"]) || empty($_POST["pswd"])) {
			$errors = true;
			$passwordError = "Inserire una password";
		}
	}

	if (!isset($_POST["c-p"]) || empty($_POST["c-p"])) {
		if (!isset($_POST["confirm-pwd"]) || empty($_POST["confirm-pwd"])) {
			$confirmPasswordError = "Reinserisci qui la password";
			$errors = true;
		} else if (!isset($_POST["pswd"]) || !isset($_POST["confirm-pwd"]) || $_POST["pswd"] != $_POST["confirm-pwd"]) {
			$confirmPasswordError = "Le due password non corrispondono";
			$errors = true;
		}
	} else if (!isset($_POST["p"]) || !isset($_POST["c-p"]) || $_POST["p"] != $_POST["c-p"]) {
		$confirmPasswordError = "Le due password non corrispondono";
		$errors = true;
	}

	if (!$errors) {
		// Recupero la password criptata dal form di inserimento.
		if (!isset($_POST["p"]) || empty($_POST["p"])) {
			if (isset($_POST["pswd"]) && !empty($_POST["pswd"])) {
				$password = $_POST["pswd"];
			}
		} else {
			$password = $_POST["p"];
		}

		// Crea una chiave casuale
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
		// Crea una password usando la chiave appena creata.
		$password = hash('sha512', $password.$random_salt);

		$query = "UPDATE ".$_SESSION['user_type_with_code']." SET password = ?, salt = ? WHERE email = ?";

		if ($insert_stmt = $conn->prepare($query)) {

			$insert_stmt->bind_param('sss', $password, $random_salt, $_SESSION['email_with_code']);

			// Esegui la query ottenuta.
	 	   if (!$insert_stmt->execute()) {
	 		   array_push($queryErrors, $insert_stmt->error);
	 	   } else {
	 		   // Successo !!!
			   deleteUserRequests($conn);

			   if (session_status() == PHP_SESSION_NONE) {
		           sec_session_start();
		       }
			   // Cancella la sessione.
		       session_destroy();

			   header("Location: success.php");
			   mysqli_close($conn);
			   exit();
	 	   }
		} else {
			array_push($queryErrors, $conn->error);
		}
	}

}

?>

<!DOCTYPE html>
<html lang="it-IT">
<head>
	<title>Reimposta Password</title>
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
	<script src="change_password.js"></script>
	<link rel="stylesheet" type="text/css" title="stylesheet" href="../navbar/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="change_password.css">
</head>

<body>
	<?php require_once '../navbar/navbar.php';?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-6 jumbotron" id="change_password_form">
				<h1 class="form-title">Reimposta password</h1>
				<form action="change_password.php" method="post" enctype="multipart/form-data">
					<div class="form-input-group">
						<div class="form-group">
							<label for="pwd">Nuova Password:</label>
							<input type="password" class="form-control" id="pwd" required placeholder="Inserisci password" name="pswd">
							<?php
								if(strlen($passwordError) !== 0) {
									echo("<div class='alert alert-danger' style='margin-top: 8px;'>$passwordError</div>");
								}
							?>
						</div>
						<div class="form-group">
							<label for="confirm-pwd">Conferma Password:</label>
							<input type="password" class="form-control" id="confirm-pwd" required placeholder="Conferma password" name="confirm-pwd">
							<?php
								if(strlen($confirmPasswordError) !== 0) {
									echo("<div class='alert alert-danger' style='margin-top: 8px;'>$confirmPasswordError</div>");
								}
							?>
						</div>
					</div>
					<div class="d-flex justify-content-center">
						<button type="submit" class="btn btn-primary btn-lg" id="submitbtn">Conferma</button>
					</div>
					<noscript>
						<div class='alert alert-warning' style='margin-top: 8px;'>
							<strong>ATTENZIONE:</strong> Questa pagina potrebbe non funzionare correttamente senza JavaScript.
							Per favore, riabilita JavaScript nel tuo Browser e ricarica la pagina.
						</div>
					</noscript>
					<?php
						if(count($queryErrors) > 0) {
							foreach ($queryErrors as &$value) {
							    echo("<div class='alert alert-danger text-center' style='margin-top: 8px;'>$value</div>");
							}
						}
					?>
				</form>
			</div>
		</div>
	</div>
</body>
</html>

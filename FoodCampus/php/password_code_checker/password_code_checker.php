<?php

$checkClientError="";
$emailError = "";
$passwordError = "";

require_once "../database.php";
require_once "../login/login_functions.php";
require_once "../utilities/direct_login.php";

$GLOBALS["errors"] = "";

$session_mail = $_SESSION['email_with_code'];
$session_user_type = $_SESSION['user_type_with_code'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$_SESSION['operation_allowed'] = true;
	if (isset($_POST["codice"])) {
		if (checkBruteAttempts($conn, $session_mail)) {
		} else {
			if (checkCode($conn, $session_mail)) {

				mysqli_close($conn);

				$conn = new mysqli("localhost", "root", "", "foodcampus");

				if ($conn->connect_errno) {
					die("Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error);
				}

				deleteUserRequests($conn, $session_mail);

				// Cancella la sessione.
				session_destroy();

				if (session_status() == PHP_SESSION_NONE) {
					sec_session_start();
				}

				$_SESSION['email_with_code'] = $session_mail;
				$_SESSION['user_type_with_code'] = $session_user_type;
				$_SESSION['operation_allowed'] = true;

				header("Location: ../change_password/change_password.php");
				mysqli_close($conn);
				exit();
			}
		}
	} else {
		$GLOBALS["errors"] = "Codice non valido";
	}
}

//Redirect to home page
function redirectToHome($conn) {
	header("Location: ../home/home.php");
	mysqli_close($conn);
	exit();
}

if (isUserLogged($conn) || !isset($_SESSION['operation_allowed']) || $_SESSION['operation_allowed'] === false) {
	unset($_SESSION['email_with_code']);
	unset($_SESSION['user_type_with_code']);
	unset($_SESSION['operation_allowed']);

	redirectToHome($conn);
}

$_SESSION['operation_allowed'] = false;

function checkCode($conn, $email) {
	$valid_attempts = time() - (60 * 3);
	$query = "SELECT code FROM richieste_cambio_password WHERE email = ? and timestamp > ?  ORDER BY id DESC LIMIT 1";

	// Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
	if ($stmt = $conn->prepare($query)) {
		$stmt->bind_param('ss', $email, $valid_attempts); // esegue il bind del parametro '$email'.
		// esegue la query appena creata.
		if (!$stmt->execute()) {
			$GLOBALS["sqlError"] = $conn->error;
			return false;
		}

		$stmt->store_result();
		$stmt->bind_result($code); // recupera il risultato della query e lo memorizza nelle relative variabili.
		$stmt->fetch();

		if($stmt->num_rows > 0) {
			if ($_POST["codice"] == $code) {
				return true;
			} else {
				$GLOBALS["errors"] = "Codice non valido";
				$now = time();
		        if (!$conn->query("INSERT INTO tentativi_inserimento_codice (email, timestamp) VALUES ('".$email."', '$now')")) {
		            $GLOBALS["sqlWarning"] = $mysqli->error;
		            return false;
		        }
				return false;
			}
		} else {
			$GLOBALS["errors"] = "Codice non valido";
			return false;
		}
	}
}

function checkBruteAttempts($conn, $email) {
	$valid_attempts = time() - (60 * 5);
	$query = "SELECT id FROM tentativi_inserimento_codice WHERE email = ? and timestamp > ?";

	// Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
	if ($stmt = $conn->prepare($query)) {
		$stmt->bind_param('ss', $email, $valid_attempts); // esegue il bind del parametro '$email'.
		// esegue la query appena creata.
		if (!$stmt->execute()) {
			$GLOBALS["sqlError"] = $conn->error;
			return false;
		}

		$stmt->store_result();
		$stmt->bind_result($code); // recupera il risultato della query e lo memorizza nelle relative variabili.
		$stmt->fetch();

		if($stmt->num_rows > 9) {
			$GLOBALS["errors"] = "Hai eseguito troppi tentativi sbagliati, riprova pi&ugrave; tardi.";
			return true;
		}
	}

	return false;
}

function deleteUserRequests($conn, $email) {

	$query = "DELETE FROM tentativi_inserimento_codice WHERE email = ?";

	if ($stmt = $conn->prepare($query)) {
		$stmt->bind_param('s', $email);

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
		$stmt->bind_param('s', $email);

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
?>
<!DOCTYPE html>
<html lang="it-IT">
<head>
	<title>Inserisci codice</title>
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

	<link rel="stylesheet" type="text/css" title="stylesheet" href="../footer/footer.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="../navbar/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="password_code_checker.css">
</head>

<body>
	<?php require_once '../navbar/navbar.php';?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6 jumbotron" id="change_password_form">
				<h1 class="form-title">Inserisci il codice</h1>
				<p class="important-text">Inserisci qui sotto il codice che hai ricevuo via email.<br/>
					<strong style="color: red;">ATTENZIONE: </strong> il codice ha una durata di 3 minuti.
				</p>
				<form action="password_code_checker.php" method="post">
					<div class="form-group">
						<label for="codice">Codice:</label>
						<input type="text" required class="form-control" id="codice"  placeholder="Inserisci il codice" name="codice">
						<?php
							if(strlen($emailError) !== 0) {
								echo("<div class='alert alert-danger' style='margin-top: 8px;'>$emailError</div>");
							}
						?>
					</div>
					<div class="d-flex justify-content-center form-group">
						<button type="submit" id="submitbtn" class="btn btn-primary btn-lg">Invia</button>
					</div>
					<?php
						if(strlen($GLOBALS["sqlError"]) !== 0) {
							echo("<div class='alert alert-danger' style='margin-top: 8px;'>".$GLOBALS["sqlError"]."</div>");
						}
						if(strlen($GLOBALS["sqlWarning"]) !== 0) {
							echo("<div class='alert alert-warning' style='margin-top: 8px;'>".$GLOBALS["sqlWarning"]."</div>");
						}
						if (strlen($GLOBALS["errors"]) !== 0) {
							echo("<div class='alert alert-danger' style='margin-top: 8px;'>".$GLOBALS["errors"]."</div>");
						}
					?>
				</form>
				<div class='alert alert-warning' style='margin-top: 8px;'><strong>ATTENZIONE: </strong>
					<br/><strong>NON</strong> ricaricare e <strong>NON</strong> uscire da questa pagina o dovrai chiedere un nuovo codice!
				</div>
			</div>
		</div>
	</div>
	<?php require_once "../footer/footer.html"; ?>
</body>
</html>

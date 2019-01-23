<?php

$checkClientError="";
$emailError = "";
$passwordError = "";

require_once "../database.php";
require_once "../login/login_functions.php";
require_once "../utilities/direct_login.php";

$GLOBALS["user"] = "Cliente";
$GLOBALS["banned"] = false;
$GLOBALS["errors"] = "";
$emailError = "";

//Redirect to home page
function redirectToHome($conn) {
	header("Location: ../home/home.php");
	mysqli_close($conn);
	exit();
}

if (isUserLogged($conn)) {
	redirectToHome($conn);
}

function isUserAllowed($mysqli, $email, $query) {
    $sentEmail = $email;

    // Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('s', $sentEmail); // esegue il bind del parametro '$email'.
        // esegue la query appena creata.
        if (!$stmt->execute()) {
            $GLOBALS["sqlError"] = $mysqli->error;
            return false;
        }
        $stmt->store_result();
        $stmt->bind_result($user_id, $email, $db_password, $salt, $blocked); // recupera il risultato della query e lo memorizza nelle relative variabili.
        $stmt->fetch();

		if($stmt->num_rows == 1) {

            if ($blocked !== 0) {
                $GLOBALS["banned"] = true;
                return false;
            }
			$GLOBALS["banned"] = false;
			return true;

        } else {
            $GLOBALS["sqlError"] = $mysqli->error;
            return false;
        }
    } else {
        $GLOBALS["sqlError"] = $mysqli->error;
        return false;
    }

    return false;
}

function checkUser($conn, $email, &$emailError) {
	$password = "";
	$query = "SELECT IDCliente, email, password, salt, bloccato FROM cliente WHERE email = ? LIMIT 1";

    if (!isUserAllowed($conn, $email, $query)) {

        if ($GLOBALS["sqlError"] === "") {
            $query = "SELECT IDFornitore, email, password, salt, bloccato FROM fornitore WHERE email = ? LIMIT 1";

            if (!isUserAllowed($conn, $email, $query)) {

                if ($GLOBALS["banned"] === false && $GLOBALS["sqlError"] === "") {
                    $emailError = "Nessun utente registrato con questo indirizzo email";
                }

                return false;
            } else {
                $GLOBALS["user"] = "Fornitore";
            }

        } else {
            return false;
        }
    } else {
        $GLOBALS["user"] = "Cliente";
    }

    if (checkbrute($email, $conn)) {
        $emailError = "Questo utente è stato bloccato temporaneamente a causa dei troppi tentativi di accesso.<br/>Riprovare pi&ugrave; tardi.";
        return false;
    }

	return true;
}

function sendMail($email, $code) {
	$to = $email;
	$subject = "Codice reimpostazione password";

	$message = "
	<html>
	<head>
		<title>HTML email</title>
		<style>
			.importantText {
				font-weight: bold;
			}
		</style>
	</head>
	<body>
		<p>Il tuo codice per reimpostare la password &egrave;: <strong class='importantText'>"
	.$code.
	"</strong></p>
	<p>
		Se <strong>NON</strong> hai richiesto il cambio della password, contatta immediatamente il supporto all'indirizzo:<br/>
		<strong class='importantText'>foodcampus.cesena@gmail.com</strong>
	</p>
	</body>
	</html>
	";

	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	return mail($to, $subject, $message, $headers);
}

function checkBruteAttempts($conn) {
	$valid_attempts = time() - (60 * 5);
	$query = "SELECT id FROM tentativi_inserimento_codice WHERE email = ? and timestamp > ?";

	// Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
	if ($stmt = $conn->prepare($query)) {
		$stmt->bind_param('ss', $_POST["email"], $valid_attempts); // esegue il bind del parametro '$email'.
		// esegue la query appena creata.
		if (!$stmt->execute()) {
			$GLOBALS["sqlError"] = $conn->error;
			return false;
		}

		$stmt->store_result();
		$stmt->bind_result($code); // recupera il risultato della query e lo memorizza nelle relative variabili.
		$stmt->fetch();

		if($stmt->num_rows > 9) {
			$GLOBALS["errors"] = "Hai inserito troppi codici sbagliati, riprova pi&ugrave; tardi.";
			return true;
		}
	}

	return false;
}

function checkBruteCodeRequests($conn) {
	$valid_attempts = time() - (60 * 5);
	$query = "SELECT id FROM richieste_cambio_password WHERE email = ? and timestamp > ?";

	// Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
	if ($stmt = $conn->prepare($query)) {
		$stmt->bind_param('ss', $_POST["email"], $valid_attempts); // esegue il bind del parametro '$email'.
		// esegue la query appena creata.
		if (!$stmt->execute()) {
			$GLOBALS["sqlError"] = $conn->error;
			return false;
		}

		$stmt->store_result();
		$stmt->bind_result($code); // recupera il risultato della query e lo memorizza nelle relative variabili.
		$stmt->fetch();

		if($stmt->num_rows > 9) {
			$GLOBALS["errors"] = "Hai richiesto il codice troppe volte, riprova pi&ugrave; tardi.";
			return true;
		}
	}

	return false;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	if (isset($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		if (checkUser($conn, $_POST["email"], $emailError)) {
			if (checkBruteCodeRequests($conn)) {
			} else {
				if (checkBruteAttempts($conn)) {
				} else {
					$code = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
					if (sendMail($_POST["email"], $code)) {
						$now = time();
				        if ($stmt = $conn->prepare("INSERT INTO richieste_cambio_password (email, code, timestamp) VALUES (?, ?, ?)")) {
							if ($stmt->bind_param('sss', $_POST["email"], $code, $now)) {
								if ($stmt->execute()) {
									// Successo !!!
									session_destroy();

									if (session_status() == PHP_SESSION_NONE) {
										sec_session_start();
									}

									$_SESSION['email_with_code'] = $_POST["email"];
									$_SESSION['user_type_with_code'] = $GLOBALS["user"];
									$_SESSION['operation_allowed'] = true;

									header("Location: ../password_code_checker/password_code_checker.php");
									mysqli_close($conn);
									exit();
								} else {
									$GLOBALS["sqlError"] = $stmt->error;
								}
							} else {
								$GLOBALS["sqlError"] = $stmt->error;
							}
				        } else {
				        	$GLOBALS["sqlError"] = $conn->error;
				        }
					} else {
						$emailError = "Errore durante l'invio dell'email.<br/>
										Se il problema persiste, contattare il supporto all'indirizzio:
										<span class='errorElement'>foodcampus.cesena@gmail.com</span>";
					}
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
	<title>Password dimenticata</title>
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

	<script src="password_forgotten.js"></script>
	<link rel="stylesheet" type="text/css" title="stylesheet" href="../footer/footer.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="../navbar/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="password_forgotten.css">
</head>

<body>
	<?php require_once '../navbar/navbar.php';?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6 jumbotron" id="forgotten_password_form">
				<h1 class="form-title">Password dimenticata</h1>
				<p class="important-text">Inserisci qui sotto il tuo indirizzo email.<br/>
					Ti invieremo un codice per reimpostare la tua password.
				</p>
				<form action="password_forgotten.php" method="post">
					<div class="form-group">
						<label for="email">Indirizzo Email:</label>
						<input type="email" required class="form-control" id="email" placeholder="Inserisci email" name="email">
						<?php
							if(strlen($emailError) !== 0) {
								echo("<div class='alert alert-danger errorElement'>$emailError</div>");
							}
						?>
					</div>
					<div class="d-flex justify-content-center form-group">
						<button type="submit" id="submitbtn" class="btn btn-primary btn-lg">Invia</button>
					</div>
					<?php
						if(strlen($GLOBALS["sqlError"]) !== 0) {
							echo("<div class='alert alert-danger errorElement'>".$GLOBALS["sqlError"]."</div>");
						}
						if(strlen($GLOBALS["sqlWarning"]) !== 0) {
							echo("<div class='alert alert-warning errorElement'>".$GLOBALS["sqlWarning"]."</div>");
						}
						if ($GLOBALS["banned"]) {
							echo("<div class='alert alert-danger errorElement'>Questo utente è stato bannato, impossibile procedere.</div>");
						}
						if (strlen($GLOBALS["errors"]) !== 0) {
							echo("<div class='alert alert-danger errorElement'>".$GLOBALS["errors"]."</div>");
						}
					?>
				</form>
			</div>
		</div>
	</div>
	<?php
		require_once "../cookie/cookie.php";
		require_once "../footer/footer.html";
	?>
</body>
</html>

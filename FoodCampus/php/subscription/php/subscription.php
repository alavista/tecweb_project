<?php
$errors = false;

$nameError = "";
$surnameError = "";
$emailError = "";
$passwordError = "";
$confirmPasswordError = "";
$selectAccountError = "";
$addressError = "";
$crossNumberError = "";
$pivaError = "";
$cityError = "";
$supplierNameError = "";
$shippingError = "";
$shippingLimitError = "";

require_once "../../database.php";

function subscript($conn) {

	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$email = $_POST['email'];
	if (isset($_POST['filename']) && !empty($_POST['filename'])) {
		$image = $_POST['filename'];
	} else {
		$image = NULL;
	}
	// Recupero la password criptata dal form di inserimento.
	$password = $_POST['p'];
	// Crea una chiave casuale
	$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	// Crea una password usando la chiave appena creata.
	$password = hash('sha512', $password.$random_salt);
	$blocked = 0;

	if ($_POST["account_selection"] === "Fornitore") {
		$address = $_POST['indirizzo'];
		$crossNumber = $_POST['ncivico'];
		$piva = $_POST['piva'];
		$city = $_POST['citta'];
		$supplierName = $_POST['nomefornitore'];
		$shipping = $_POST['shippingcost'];
		$shippingLimit = $_POST['shippinglimit'];
		if (isset($_POST['sitoweb']) && !empty($_POST['filename'])) {
			$web_site = $_POST['sitoweb'];
		} else {
			$web_site = NULL;
		}
		$enabled = 0;

		$query = "INSERT INTO fornitore (nome, citta, indirizzo_via, indirizzo_numero_civico, costi_spedizione, soglia_spedizione_gratuita, abilitato, email, sito_web, partita_iva, immagine, password, salt, bloccato) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		if ($insert_stmt = $conn->prepare($query)) {
		   $insert_stmt->bind_param('ssssiiissssssi', $name, $city, $address, $crossNumber, $shipping, $shippingLimit, $enabled, $email, $web_site, $piva, $image, $password, $random_salt, $blocked);
		   // Esegui la query ottenuta.
		   $insert_stmt->execute();
		}
	} else {
		$query = "INSERT INTO cliente (nome, cognome, email, immagine, password, salt, bloccato) VALUES (?, ?, ?, ?, ?, ?, ?)";

		if ($insert_stmt = $conn->prepare($query)) {
		   $insert_stmt->bind_param('ssssssi', $name, $surname, $email, $image, $password, $random_salt, $blocked);
		   // Esegui la query ottenuta.
		   $insert_stmt->execute();
		}
	}
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	if (!isset($_POST["name"]) || empty($_POST["name"])) {
		$nameError = "Inserire un nome";
		$errors = true;
	}

	if (!isset($_POST["surname"]) || empty($_POST["surname"])) {
		$surnameError = "Inserire un cognome";
		$errors = true;
	}

	if (!isset($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		$emailError = "Inserire un indirizzo email valido";
	}

	if (!isset($_POST["p"]) || empty($_POST["p"])) {
		$passwordError = "Inserire una password";
		$errors = true;
	}

	if (!isset($_POST["c-p"]) || empty($_POST["c-p"])) {
		$confirmPasswordError = "Reinserisci qui la password";
		$errors = true;
	} else if (!isset($_POST["p"]) || !isset($_POST["c-p"]) || $_POST["p"] != $_POST["c-p"]) {
		$confirmPasswordError = "Le due password non corrispondono";
		$errors = true;
	}

	if (!isset($_POST["account_selection"]) || empty($_POST["account_selection"]) || ($_POST["account_selection"] !== "Cliente" && $_POST["account_selection"] !== "Fornitore")) {
		$selectAccountError = "Scegliere il tipo di account tra i due presenti";
		$errors = true;
	}

	if ($_POST["account_selection"] === "Fornitore") {
		if (!isset($_POST["indirizzo"]) || empty($_POST["indirizzo"])) {
			$addressError = "Inserire un indirizzo";
			$errors = true;
		}

		if (!isset($_POST["ncivico"]) || empty($_POST["ncivico"])) {
			$crossNumberError = "Inserire un numero civico";
			$errors = true;
		}

		if (!isset($_POST["piva"]) || empty($_POST["piva"])) {
			$pivaError = "Inserire una partita IVA";
			$errors = true;
		}

		if (!isset($_POST["citta"]) || empty($_POST["citta"])) {
			$cityError = "Inserire una citt&agrave;";
			$errors = true;
		}

		if (!isset($_POST["nomefornitore"]) || empty($_POST["nomefornitore"])) {
			$supplierNameError = "Inserire il vostro nome fornitore";
			$errors = true;
		}

		if (!isset($_POST["shippingcost"]) || empty($_POST["shippingcost"]) || $_POST["shippingcost"] < 0 || $_POST["shippingcost"] > 10 || !is_numeric($_POST["shippingcost"])) {
			$shippingError = "Inserire un costo di spedizione compreso tra 0 e 10";
			$errors = true;
		}

		if (!isset($_POST["shippinglimit"]) || empty($_POST["shippinglimit"]) || $_POST["shippinglimit"] < 0 || $_POST["shippinglimit"] > 10 || !is_numeric($_POST["shippinglimit"])) {
			$shippingLimitError = "Inserire un limite di spedizione gratuita compreso tra 0 e 10";
			$errors = true;
		}

	}

	if (!$errors) {

		$query = "SELECT IDCliente FROM cliente WHERE email = ?";
		if ($stmt = $conn->prepare($query)) {
			$stmt->bind_param('s', $_POST["email"]);
			$stmt->execute();
	        $stmt->store_result();

	        if($stmt->num_rows > 0) {
	           $emailError = "Un utente è già registrato con questo indirizzo email";
	        } else {
				$query = "SELECT IDFornitore FROM fornitore WHERE email = ?";
	    		if ($stmt = $conn->prepare($query)) {
					$stmt->bind_param('s', $_POST["email"]);
		    		$stmt->execute();
		            $stmt->store_result();

					if($stmt->num_rows > 0) {
						$emailError = "Un utente è già registrato con questo indirizzo email";
					} else {
						subscript($conn);
					}
				}
	        }
		}

	}
}
?>

<!DOCTYPE html>
<html lang="it-IT">
<head>
	<title>Iscriviti</title>
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

	<script src="../js/subscription_account_selection.js"> </script>
	<script src="../js/subscription_input_checker.js"> </script>
	<script src="../../../js/utilities/sha512.js"></script>
	<script src="../../../js/utilities/form_password_encoder.js"></script>

	<link rel="stylesheet" type="text/css" title="stylesheet" href="/tecweb_project/FoodCampus/css/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="/tecweb_project/FoodCampus/php/subscription/css/subscription.css">
</head>

<body>
	<?php require_once '../../navbar.php';?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-6 jumbotron mx-auto" id="loginform">
				<h1 id="first_title">Crea un Account</h1>
				<form action="subscription.php" method="post">
					<div class="form-input-group">
						<h3 class="form-title">Dati personali</h3>
						<div class="form-group">
							<label for="nome">Nome:</label>
							<input type="text" class="form-control" id="nome" required placeholder="Inserisci il nome" name="name">
							<?php
								if(strlen($nameError) !== 0) {
									echo("<div class='alert alert-danger' style='margin-top: 8px;'>$nameError</div>");
								}
							?>
						</div>
						<div class="form-group">
							<label for="cognome">Cognome:</label>
							<input type="text" class="form-control" id="cognome" required placeholder="Inserisci il cognome" name="surname">
							<?php
								if(strlen($surnameError) !== 0) {
									echo("<div class='alert alert-danger' style='margin-top: 8px;'>$surnameError</div>");
								}
							?>
						</div>
					</div>
					<div class="form-input-group">
						<h3 class="form-title">Email & Password</h3>
						<div class="form-group">
							<label for="email">Indirizzo Email:</label>
							<input type="email" class="form-control" id="email" required placeholder="Inserisci email" name="email">
							<?php
								if(strlen($emailError) !== 0) {
									echo("<div class='alert alert-danger' style='margin-top: 8px;'>$emailError</div>");
								}
							?>
						</div>
						<div class="form-group">
							<label for="pwd">Password:</label>
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
						<div class="form-group">
							<label for="myFile">Immagine del profilo (facoltativo):</label>
							<input type="file" id="myFile" name="filename" class="border" accept="image/*">
						</div>
					</div>
					<div class="form-input-group">
						<h3 class="form-title">Tipo di Account</h3>
						<div class="form-group">
							<label for="sel">Scegli il tipo di account che vuoi creare:</label>
							<select class="form-control" id="sel" name="account_selection">
						        <option>Cliente</option>
						        <option>Fornitore</option>
							</select>
							<?php
								if(strlen($selectAccountError) !== 0) {
									echo("<div class='alert alert-danger' style='margin-top: 8px;'>$selectAccountError</div>");
								}
							?>
						</div>
					</div>
					<div class="form-input-group" id="form-fornitore">
						<h3 class="form-title">Dati Fornitore</h3>
							<div class="form-group">
								<label for="indirizzo">Indirizzo:</label>
								<input type="text" class="form-control" id="indirizzo" placeholder="Inserisci il tuo indirizzo" name="indirizzo">
								<?php
									if(isset($_POST["account_selection"]) && $_POST["account_selection"] === "Fornitore" && strlen($addressError) !== 0) {
										echo("<div class='alert alert-danger' style='margin-top: 8px;'>$addressError</div>");
									}
								?>
							</div>
							<div class="form-group">
								<label for="ncivico">Numero Civico:</label>
								<input type="text" class="form-control" id="ncivico" placeholder="Inserisci il numero civico" name="ncivico">
								<?php
									if(isset($_POST["account_selection"]) && $_POST["account_selection"] === "Fornitore" && strlen($crossNumberError) !== 0) {
										echo("<div class='alert alert-danger' style='margin-top: 8px;'>$crossNumberError</div>");
									}
								?>
							</div>
							<div class="form-group">
								<label for="piva">Partita IVA:</label>
								<input type="text" class="form-control" id="piva" placeholder="Inserisci la Partita IVA" name="piva">
								<?php
									if(isset($_POST["account_selection"]) && $_POST["account_selection"] === "Fornitore" && strlen($pivaError) !== 0) {
										echo("<div class='alert alert-danger' style='margin-top: 8px;'>$pivaError</div>");
									}
								?>
							</div>
							<div class="form-group">
								<label for="citta">Citt&agrave;:</label>
								<input type="text" class="form-control" id="citta" placeholder="Inserisci la tua citt&agrave;" name="citta">
								<?php
									if(isset($_POST["account_selection"]) && $_POST["account_selection"] === "Fornitore" && strlen($cityError) !== 0) {
										echo("<div class='alert alert-danger' style='margin-top: 8px;'>$cityError</div>");
									}
								?>
							</div>
							<div class="form-group">
								<label for="nomefornitore">Nome Fornitore:</label>
								<input type="text" class="form-control" id="nomefornitore" placeholder="Inserisci il nome della tua attivit&agrave;" name="nomefornitore">
								<?php
									if(isset($_POST["account_selection"]) && $_POST["account_selection"] === "Fornitore" && strlen($supplierNameError) !== 0) {
										echo("<div class='alert alert-danger' style='margin-top: 8px;'>$supplierNameError</div>");
									}
								?>
							</div>
							<div class="form-group">
								<label for="costo-spedizione">Costo spedizione:</label>
								<div class="input-group mb-3">
							      <div class="input-group-prepend">
							        <span class="input-group-text">€</span>
							      </div>
							      <input type="number" value="0.00" max= "10.00" min="0" step="0.01" data-number-to-fixed="2" class="form-control spedition" id="costo-spedizione" name="shippingcost">
								  <?php
  									if(isset($_POST["account_selection"]) && $_POST["account_selection"] === "Fornitore" && strlen($shippingError) !== 0) {
  										echo("<div class='alert alert-danger' style='margin-top: 8px;'>$shippingError</div>");
  									}
  								?>
							    </div>
							</div>
							<div class="form-group">
								<label for="soglia-spedizione">Soglia spedizione gratuita:</label>
								<div class="input-group mb-3">
							      <div class="input-group-prepend">
							        <span class="input-group-text">€</span>
							      </div>
							      <input type="number" value="0.00" max= "10.00" min="0" step="0.01" data-number-to-fixed="2" class="form-control spedition" id="soglia-spedizione" name="shippinglimit">
								  <?php
  									if(isset($_POST["account_selection"]) && $_POST["account_selection"] === "Fornitore" && strlen($shippingLimitError) !== 0) {
  										echo("<div class='alert alert-danger' style='margin-top: 8px;'>$shippingLimitError</div>");
  									}
  								?>
							    </div>
							</div>
							<div class="form-group">
								<label for="sitoweb">Sito Web (facoltativo):</label>
								<input type="text" class="form-control" id="sitoweb" placeholder="Inserisci la URL del tuo sito Web" name="sitoweb">
							</div>
						</div>

					<div class="d-flex justify-content-center">
						<button type="submit" class="btn btn-primary btn-lg" id="submitbtn">Iscriviti</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

</html>
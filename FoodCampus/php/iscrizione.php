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
	<script src="../jquery/jquery-3.2.1.min.js"> </script>
	<script src="../js/iscrizione.js"> </script>

	<link rel="stylesheet" type="text/css" title="stylesheet" href="../css/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="../css/iscrizione.css">
</head>

<body>
	<?php require_once 'navbar.php';?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-6 jumbotron mx-auto" id="loginform">
				<h1 id="first_title">Crea un Account</h1>
				<form action="/action_page.php" method="post">
					<div class="form-input-group">
						<h3 class="form-title">Dati personali</h3>
						<div class="form-group">
							<label for="nome">Nome:</label>
							<input type="text" class="form-control" id="nome" required placeholder="Inserisci il nome" name="nome">
						</div>
						<div class="form-group">
							<label for="cognome">Cognome:</label>
							<input type="text" class="form-control" id="cognome" required placeholder="Inserisci il cognome" name="cognome">
						</div>
					</div>
					<div class="form-input-group">
						<h3 class="form-title">Email & Password</h3>
						<div class="form-group">
							<label for="email">Indirizzo Email:</label>
							<input type="email" class="form-control" id="email" required placeholder="Inserisci email" name="email">
						</div>
						<div class="form-group">
							<label for="pwd">Password:</label>
							<input type="password" class="form-control" id="pwd" required placeholder="Inserisci password" name="pswd">
						</div>
						<div class="form-group">
							<label for="confirm-pwd">Conferma Password:</label>
							<input type="password" class="form-control" id="confirm-pwd" required placeholder="Conferma password" name="confirm-pwd">
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
						</div>
					</div>
					<div class="form-input-group" id="form-fornitore">
						<h3 class="form-title">Dati Fornitore</h3>
						<div class="form-group">
							<div class="form-group">
								<label for="indirizzo">Indirizzo:</label>
								<input type="text" class="form-control" id="indirizzo" placeholder="Inserisci il tuo indirizzo" name="indirizzo">
							</div>
							<div class="form-group">
								<label for="ncivico">Numero Civico:</label>
								<input type="text" class="form-control" id="ncivico" placeholder="Inserisci il numero civico" name="ncivico">
							</div>
							<div class="form-group">
								<label for="piva">Partita IVA:</label>
								<input type="text" class="form-control" id="piva" placeholder="Inserisci la Partita IVA" name="piva">
							</div>
							<div class="form-group">
								<label for="citta">Citt&agrave;:</label>
								<input type="text" class="form-control" id="citta" placeholder="Inserisci la tua citt&agrave;" name="citta">
							</div>
							<div class="form-group">
								<label for="nomefornitore">Nome Fornitore:</label>
								<input type="text" class="form-control" id="nomefornitore" placeholder="Inserisci il nome della tua attivit&agrave;" name="nomefornitore">
							</div>
							<div class="form-group">
								<label for="sitoweb">Sito Web (facoltativo):</label>
								<input type="text" class="form-control" id="sitoweb" placeholder="Inserisci la URL del tuo sito Web" name="sitoweb">
							</div>
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

<?php
	if(isset($_SESSION["admin"])) {
		header("Location: manage-database.php");
	}
?>
<!DOCTYPE html>
<html lang="it-IT">
	<head>
		<title>Pannello Amministratore</title>
		<meta charset ="UTF-8">
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
	</head>

	<body>
		<div class="container">
			
			<div class="row">
				<div class="col-xs-12">
					<h1>Pannello amministratore</h1>
				
					<form action="php/login-admin.php" method="post">
					  <div class="form-group">
					    <label for="name">Nome</label>
					    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
					  </div>
					  <div class="form-group">
					    <label for="password">Password</label>
					    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
					  </div>
					  <button type="submit" class="btn btn-primary" name="submit">Login</button>
					</form>

				</div>

			</div>
		</div>
	</body>


</html>
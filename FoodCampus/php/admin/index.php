<?php




?>

<!DOCTYPE html>
<html lang="it-IT">
	<head>
		<title>Pannello Amministratore</title>
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
         <script src="index.js"></script> 
         <link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<div class="container">
			<nav role="navigation">
				<ul class="nav nav-pills nav-justified">
				  <li id="managerDB" class="active"><a href="#ciao">Gestione Database</a></li>
				  <li id="enableSupplier"><a href="#">Abilitazione nuovi fornitori</a></li>
				  <li id="blockedUser"><a href="#">Utenti bloccati</a></li>
				</ul>
			</nav>
			
			<div class="row">

			<div class="manager-db">
				<nav class="col-md-2 d-none d-md-block bg-light sidebar">
		          <div class="sidebar-sticky">
		            <ul class="nav flex-column">
		              <li class="nav-item">
		                <a class="nav-link active" href="#">
		                  <span data-feather="home"></span>
		                  Clienti <span class="sr-only">(current)</span>
		                </a>
		              </li>
		              <li class="nav-item">
		                <a class="nav-link" href="#">
		                  <span data-feather="file"></span>
		                  Fornitori
		                </a>
		              </li>
		              <li class="nav-item">
		                <a class="nav-link" href="#">
		                  <span data-feather="shopping-cart"></span>
		                  Categorie
		                </a>
		              </li>
		              <li class="nav-item">
		                <a class="nav-link" href="#">
		                  <span data-feather="users"></span>
		                  Prodotti
		                </a>
		              </li>
		              <li class="nav-item">
		                <a class="nav-link" href="#">
		                  <span data-feather="bar-chart-2"></span>
		                  Ordini
		                </a>
		              </li>
		              <li class="nav-item">
		                <a class="nav-link" href="#">
		                  <span data-feather="layers"></span>
		                  Recensioni
		                </a>
		              </li>
		              <li class="nav-item">
		                <a class="nav-link" href="#">
		                  <span data-feather="layers"></span>
		                  Notifiche
		                </a>
		              </li>
		            </ul>
		          </div>
		        </nav>
		    </div>

	        <div class="manager-db">Gestione DB</div>

	        <div class="enable-supplier">Abilita fornitori</div>

	        <div class="blocked-user">Utenti bloccati</div>

			</div>
		</div>
	</body>

	<style>
		
	</style>


</html>
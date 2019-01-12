<!DOCTYPE html>
<html lang="it-IT">
<head>
	<title>Ricerca Prodotti</title>
	<metacharset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Notify -->
	<?php require_once '../navbar/filesForNotify.html'; ?>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<!--Font awesome-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

	<script src="products_research.js"></script>

	<link rel="stylesheet" type="text/css" title="stylesheet" href="../navbar/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="products_research.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="../footer/footer.css">
</head>
<body>
	<?php require_once '../navbar/navbar.php';?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div id="mainForm">
					<section id="categoriesSection">
						<h1>RICERCA PRODOTTI</h1>
						<noscript>
							<div class='alert alert-danger' style='margin-top: 8px;'>
								<strong>ATTENZIONE:</strong> Questa pagina NON funziona senza JavaScript.
								Per favore, riabilita JavaScript nel tuo Browser e ricarica la pagina.
							</div>
						</noscript>
						<div class="row">
							<div class="col">
								<div id="categoryField">
								</div>
								<div class="form-group form-check">
									<input class="form-check-input" type="checkbox" id="vegan_checkbox" name="vegan_checkbox">
									<label for="vegan_checkbox">Solo prodotti vegani</label>
								</div>
								<div class="form-group form-check">
									<input class="form-check-input" type="checkbox" id="celiac_checkbox" name="celiac_checkbox">
									<label for="celiac_checkbox">Solo prodotti per celiaci</label>
								</div>
							</section>
							<section id="resultsSection">
								<div id="resultsField" class="container-fluid">
									<h2 hidden>Risulati ricerca</h2>
									<div hidden class="form-group">
										<label for="sort_selection">Ordina risultati per:</label>
										<select class="form-control" id="sort_selection" name="sort_selection">
											<option selected="selected">Voto Fornitore (decrescente)</option>
											<option>Voto Fornitore (crescente)</option>
											<option>Prezzo (decrescente)</option>
											<option>Prezzo (crescente)</option>
											<option>Nome Prodotto (A-Z)</option>
											<option>Nome Prodotto (Z-A)</option>
									        <option>Nome Fornitore (A-Z)</option>
											<option>Nome Fornitore (Z-A)</option>
										</select>
									</div>
									<div hidden id="result_content">
										<table class="table table-hover table-sm table-responsive-sm">
											<thead>
												<tr>
													<th scope="col">Prodotto</th>
													<th scope="col">Prezzo</th>
													<th scope="col">Fornitore</th>
													<th scope="col">Voto fornitore</th>
													<th scope="col">Aggiungi al carrello</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require_once "../footer/footer.html"; ?>
</body>
</html>

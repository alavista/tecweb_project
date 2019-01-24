<!DOCTYPE html>
<html lang="it-IT">
<head>
	<title>Ricerca Fornitori</title>
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

	<script src="suppliers_research.js"></script>
	<script src="../user/suppliers/js/supplierFunctions.js"></script>

	<link rel="stylesheet" type="text/css" title="stylesheet" href="../navbar/navbar.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="../user/suppliers/css/starReview.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="suppliers_research.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="../footer/footer.css">
</head>
<body>
	<?php require_once '../navbar/navbar.php';?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div id="mainForm">
					<section id="filterSection">
						<h2>RICERCA FORNITORI</h2>
						<noscript>
							<div class='alert alert-danger errorElement'>
								<strong>ATTENZIONE:</strong> Questa pagina NON funziona senza JavaScript.
								Per favore, riabilita JavaScript nel tuo Browser e ricarica la pagina.
							</div>
						</noscript>
						<div class="row">
							<div class="col">
								<div id="filterField">
									<div id="modalForm" class="form-group form-check">
										<label for="modalButton">Categorie desiderate:&nbsp;&nbsp;</label>
										<button type="button" id="modalButton" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
											Imposta filtro
										</button>
										<!-- The Modal -->
										<div class="modal fade" id="myModal">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<!-- Modal Header -->
													<div class="modal-header">
														<h3 class="modal-title">Mostra i fornitori che vendono:</h3>
														<button type="button" class="close" data-dismiss="modal">&times;</button>
													</div>
													<!-- Modal body -->
													<div class="modal-body">
														<?php
															$error = "";
															if (!($stmt = $conn->prepare("SELECT c.nome FROM categoria c"))) {
																$error = $conn->error;
															}

															if (!$stmt->execute()) {
																$error = $stmt->error;
															}

															if (!($result = $stmt->get_result())) {
																$error = $stmt->error;
															}

															if (strlen($error) !== 0) {
																echo("<div class='alert alert-danger errorElement'>$error</div>");
															} else {
																echo "<div class='form-group form-check'>";
																while ($row = $result->fetch_assoc()) {
																	echo "<div><input class='big-checkbox-style big-checkbox  modal-checkbox form-check-input' type='checkbox' checked id='".$row["nome"]."' name='".$row["nome"]."'>";
																	echo "<label for='".$row["nome"]."'>".$row["nome"]."</label></div>";
																}
																echo "</div>";
															}

															$stmt->close();
														?>
													</div>
													<!-- Modal footer -->
													<div class="modal-footer">
														<div class="row d-flex">
															<div class="col">
																<button type="button" id="outAllButton" class="btn btn-warning">Nessuno</button>
																<button type="button" id="selectAllButton" class="btn btn-success">Tutti</button>
																<button type="button" id="savebutton" class="btn btn-primary" data-dismiss="modal">Salva</button>
																<button type="button" class="btn btn-danger" data-dismiss="modal">Annulla</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group form-check">
										<input class="big-checkbox form-check-input" type="checkbox" id="vegan_checkbox" name="vegan_checkbox">
										<label for="vegan_checkbox">Solo fornitori con prodotti vegani</label>
									</div>
									<div class="form-group form-check">
										<input class="big-checkbox form-check-input" type="checkbox" id="celiac_checkbox" name="celiac_checkbox">
										<label for="celiac_checkbox">Solo fornitori con prodotti per celiaci</label>
									</div>
									<div class="form-group">
										<label for="sort_selection">Ordina risultati per:</label>
										<select class="form-control" id="sort_selection" name="sort_selection">
											<option selected="selected">Voto Fornitore (decrescente)</option>
											<option>Voto Fornitore (crescente)</option>
											<option>Nome Fornitore (A-Z)</option>
											<option>Nome Fornitore (Z-A)</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</section>
					<section id="resultsSection">
						<div id="resultsField" class="container-fluid">
							<h3>Risultati ricerca</h3>
							<div id="result_content">
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
	<?php
		require_once "../cookie/cookie.php";
		require_once "../footer/footer.html";
	?>
</body>
</html>

<?php

	session_start();
	if(!isset($_SESSION["admin"])) {
		header("Location: index.html");
	}

    require_once("../database.php");

    $sqlColumnName = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'fornitore'";
    $resultColumnName = $GLOBALS["conn"]->query($sqlColumnName);

    $sqlRows = "SELECT * FROM fornitore WHERE abilitato = FALSE";
    $resultRows = $GLOBALS["conn"]->query($sqlRows);

?>

<!DOCTYPE html>
<html lang="it-IT">
	<head>
		<title>Abilitazione fornitori</title>
		<meta charset="UTF-8">
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

			<?php include_once("navtab.php") ?>
			
			<div class="row">

				<div id="enable-supplier">
					<?php
						if($resultRows->num_rows == 0) {
							echo "<div class='alert alert-primary' role='alert'>Nessun fornitore da abilitare</div>";
						} else {

							$columnsName = array();
						    echo "<div class='table-responsive'><table class='table-hover'><tr>";
						    while($row = mysqli_fetch_array($resultColumnName)) {
						        echo "<th>".$row["COLUMN_NAME"]."</th>";
						        array_push($columnsName, $row["COLUMN_NAME"]);
						    }
						    echo "<th></th></tr>";

						    while($row = mysqli_fetch_array($resultRows)) {
						        echo "<tr id='".$row["IDFornitore"]."''>";
						        foreach($columnsName as $columnName) {
						            echo "<td>".$row[$columnName]."</td>";
						        }
						        echo "<td><button type='button' class='btn btn-primary enable-button' value='".$row["IDFornitore"]."'>Abilita</button></td></tr>";
						    }
						    echo "</table></div>";
						}

					?>
					<div id=esito></div>
		        </div>

			</div>
		</div>
	</body>

</html>
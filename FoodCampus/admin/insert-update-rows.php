<?php

	require_once("../php/database.php");
	require_once("php/db-info.php");

	if(!isset($_GET["table"])) {
		header("location: index.php");
	}
	$table = $_GET["table"];

?>

<!DOCTYPE html>
<html lang="it-IT">
	<head>
		<title>Gestione Database</title>
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
		<script src="js/insert-update-rows.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>

	<body>
		<div class="container">
		
			<?php include_once("php/navtab.php") ?>

			<div class="row">

				<div class="col-xs-12">
					<h1>Inserimento <?php echo $table; ?></h1>
					<form>
						<input type="text" name="table" class="invisible" value=<?php echo "'".$table."'"; ?>/>

						<?php
							$update = false;
							if(isset($_GET["id"])) {
								$id = $_GET["id"];
								$sql = getQuerySearchByID($table, $id);
								$result = $GLOBALS["conn"]->query($sql);
								if($result->num_rows != 0) {
									$rowToUpdate = mysqli_fetch_array($result);
									$update = true; 
								}
						    }
						    $sql = "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$table."'";
						    $result = $GLOBALS["conn"]->query($sql);
							if($result->num_rows == 0) {
					            echo "<div class='alert alert-primary' role='alert'>Errore</div>";
					        } else {
					        	$row = mysqli_fetch_array($result);
					        }

				            while($row = mysqli_fetch_array($result)) {
				                $columnsName[$row["COLUMN_NAME"]] = $row["DATA_TYPE"];
				            }

						    foreach($columnsName as $key => $value) {
								if(!in_array($key, $PRIMARY_KEYS)) {
									echo "<div class='form-group'><label for='".$key."'>".$key."&nbsp;</label>";
									if($key == "immagine") {
										echo "<input type='file' name='".$key."'";
									} else {
										if(in_array($value, $DB_NUMERIC_TYPES)) {
											echo "<input type='number' name='".$key."' ";
											if(in_array($value, $DB_FLOAT_TYPES)) {
												echo "step='0.01' ";
											}
										} else {
											echo "<input type='text' name='".$key."'";
										}
									}
									if($update) {
										echo "value='".$rowToUpdate[$key]."'";
									}
									echo "/></div>";
								} else {
									//se vero sono nel caso delle chiavi esterne
									if($key != $PRIMARY_KEYS[$table]) {
										$extern_table = array_search($key, $PRIMARY_KEYS);
										echo "<div class='form-group'><label for='".$key."'>".$extern_table."&nbsp;</label>";
										$sql2 = getQuerySearchExtern($extern_table);
										$result2 = $GLOBALS["conn"]->query($sql2);
										if($result2->num_rows != 0) {
									        echo "<select name='".$key."'>";
									        while($row2 = mysqli_fetch_array($result2)) {
									        	echo "<option value='".$row2[$key]."'";
									        	if($rowToUpdate[$key] == $row2[$key]) {
									        		echo " selected";
									        	}
									        	echo ">".implode(",", array_unique($row2))."</option>";
									        }
									        echo "</select></div>";
										}
									}
								}
							}
							?>
						<input id="submit" type="button" class="btn" value=<?php echo "'Inserisci ".$table."'";?>/>
					</form><br/>
					<div id="result"></div>
				</div>
			</div>
		</div>
	</body>

</html>
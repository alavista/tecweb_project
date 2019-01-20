<?php
require_once "../database.php";
require_once "../utilities/direct_login.php";

if (!($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET["id"]) &&
            is_numeric($_GET["id"]) && ctype_digit($_GET["id"]) && $_GET["id"] >= 0 &&
            isUserLogged($conn) && ((!empty($_SESSION["user_id"]) && $_SESSION["user_id"] == $_GET["id"]) ||
                    (isset($_COOKIE["user_id"]) && $_COOKIE["user_id"] == $_GET["id"])))) {
        redirectToPageNotFound($conn);
    }
?>
<!DOCTYPE html>
<html lang="it-IT">
    <head>
        <title>FOOD CAMPUS</title>
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
         <!-- Notify -->
         <?php require_once '../navbar/filesForNotify.html'; ?>
         <!--Font awesome-->
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <script src="supplier-orders.js"></script>
         <!--CSS-->
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../navbar/navbar.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../../css/utilities.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../footer/footer.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="supplier-orders.css">
    </head>
    <body>
        <div class="container">
        	<div class="row">
        		<div class="col-md-8 offset-md-2">
		            <?php
		            require_once '../navbar/navbar.php';
		            $_SESSION["page"] = "http://localhost/tecweb_project/FoodCampus/php/home/home.php";
		            ?>
		            <div class="jumbotron <?php if ($supplier) { echo 'jumbotronSupplierStartAfterNavbar'; } else { echo 'jumbotronClientStartAfterNavbar'; } ?>">
		                <span class="text-center"><h1>ORDINI IN ATTESA</h1></span>
		                <div id="medias">
		                    <?php
		                    $query = "SELECT * FROM ordine AS O, prodotto_in_ordine AS P_O, prodotto AS P WHERE O.IDOrdine = P_O.IDOrdine && P_O.IDProdotto = P.IDProdotto && P.IDFornitore = ? && consegnato = 0 GROUP BY O.IDOrdine ";
		                    if ($stmt = $conn->prepare($query)) {
		                        $stmt->bind_param("i", $_GET["id"]);
		                        if ($stmt->execute()) {
		                            $res = $stmt->get_result();
		                            if ($res->num_rows > 0) {
		                                while($row = $res->fetch_assoc()) {
		                                    ?>
		                                    <div class="media border p-3">
		                                        <div class="media-body">
		                                            <h4><?php echo "Ordine n.".$row["IDOrdine"]; ?></h4>
		                                            <ul class="list-unstyled">
		                                            <?php
		                                            	$query2 = "SELECT * FROM prodotto_in_ordine AS P_O, prodotto AS P WHERE P_O.IDProdotto = P.IDProdotto && P_O.IDOrdine = ?";
		                                            	if ($stmt2 = $conn->prepare($query2)) {
									                        $stmt2->bind_param("i", $row["IDOrdine"]);
									                        if ($stmt2->execute()) {
									                            $res2 = $stmt2->get_result();
									                            if ($res2->num_rows > 0) {
									                                while($row2 = $res2->fetch_assoc()) {
						   											?>
						                                            	<li><?php echo $row2["nome"]; ?></li>
						                                            <?php
									                                }
									             				}
									             			}
									             		}
									             	?>
									             	</ul>
									             	<p><?php echo "Prezzo totale: ".$row["prezzo"]." € - Orario di consegna: ".sprintf("%02d", $row["orario_consegna_ora"]).":".sprintf("%02d", $row["orario_consegna_minuti"]); ?>
									             	</p>
									             	<button type="button" value="<?php echo $row["IDOrdine"]; ?>" class="btn btn-primary pull-right deliver-order">Consegna ordine</button>
		                                        </div>
		                                    </div>
		                                    <?php
		                                }
		                            } else {
		                            ?>
		                            	<br/><p class="text-center">Nessun ordine in attesa</p>
		                            <?php
		                            }
		                        }
		                    }
		                ?>
		            	</div>
		            </div>
	            </div>
	        </div>
        </div>
        <?php require_once "../footer/footer.html"; ?>
    </body>
</html>

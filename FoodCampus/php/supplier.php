<?php require_once 'database.php';?>
<!DOCTYPE html>
<html lang="it-IT">
    <head>
        <title>FOOD CAMPUS</title>
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
         <!--JavaScript-->
         <script src="../js/supplier.js" type="text/javascript"></script>
         <!--Font awesome-->
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <!--CSS-->
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../css/navbar.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../css/supplier.css">
    </head>
    <body>
        <div class="container">
        <?php
            require_once 'navbar.php';
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $query_sql = "SELECT * FROM fornitore WHERE nome = '".$_GET['nome']."'";
                $result = $conn->query($query_sql);
               	if ($result !== false && $result->num_rows > 0) {
                    $supplier = $result->fetch_assoc();
                    ?>
                    <div class = "text-center" id = "supplierName">
                        <h1>
                        <?php
                            echo strtoupper($supplier["nome"]);
                            if (isset($_COOKIE["user_email"])) {
                                if ($supplier["email"] == $_COOKIE["user_email"]) {
                                ?>
                                    <a class="btn btn-secondary" href="#" role="button">Modifica</a>
                                    <?php
                                }
                            }
                                    ?>
                        </h1>
                        <img src="../res/suppliers/<?php echo $supplier["immagine"] != NULL ? $supplier["immagine"] : 'default.jpg'?>" class="img-fluid img-thumbnail" alt="Logo fornitore">
                    <?php
                }
                    ?>
                    </div>
                <section>
                    <div class="jumbotron">
                        <span class="text-center"><h2>Informazioni</h2></span>
                        <span class="font-weight-bold">Città:</span><p><?php echo $supplier["citta"];?></p>
                        <span class="font-weight-bold">Indirizzo:</span><p><?php echo $supplier["indirizzo_via"];?></p>
                        <span class="font-weight-bold">Numero civico:</span><p><?php echo $supplier["indirizzo_numero_civico"];?></p>
                        <span class="font-weight-bold">Costi di spedizione:</span><p><?php echo $supplier["costi_spedizione"];?> €</p>
                        <span class="font-weight-bold">Sito web:</span><br/><a href="<?php echo $supplier["sito_web"];?>"><?php echo $supplier["sito_web"];?></a></p>
                    </div>
                </section>
                <section>
                    <div class="jumbotron">
                        <span class="text-center"><h2>Menù</h2></span>
                        <h3>Listino<i class="fas fa-utensils"></i></h3>
                        <?php
                        $isSupplier = false;
                        if (isset($_COOKIE["user_email"])) {
                            $query_sql="SELECT DISTINCT * FROM fornitore WHERE email = '".$_COOKIE['user_email']."'";
                            $result = $conn->query($query_sql);
                            $isSupplier = ($result !== false && $result->num_rows > 0) ? true : false;
                        }
                        $idSupplier = $supplier["IDFornitore"];
                        $query_sql="SELECT DISTINCT IDCategoria FROM prodotto WHERE IDFornitore =  '$idSupplier'";
                        $result = $conn->query($query_sql);
                        if ($result !== false && $result->num_rows > 0) {
                            while($category = $result->fetch_assoc()) {
                                $idCategory = $category["IDCategoria"];
                                $query_sql = "SELECT nome from categoria where IDCategoria = $idCategory";
                                $result1 = $conn->query($query_sql);
                                if ($result1 !== false && $result1->num_rows > 0) {
                                ?>
                                    <h4><?php echo ucwords($result1->fetch_assoc()["nome"]); ?></h4>
                                    <?php
                                    $query_sql="SELECT nome, costo FROM prodotto WHERE IDFornitore = '$idSupplier' AND IDCategoria = '$idCategory'";
                                    $result2 = $conn->query($query_sql);
                                    if ($result2 !== false && $result2->num_rows > 0) {
                                        while($product = $result2->fetch_assoc()) {
                                        ?>
                                            <div class="product">
                                                <span class="float-left"><?php echo $product["nome"]; ?></span>
                                                <span class="float-right">
                                                    <span><?php echo $product["costo"]; ?> €</span>
                                                    <span <?php if ($isSupplier) { echo "data-toggle='popover' data-trigger='hover' data-content='I fornitori non possono acquistare'"; } ?>>
                                                        <button type="button" class="btn btn-deafult" <?php if ($isSupplier) { echo "style='pointer-events: none;' disabled"; } ?>><i class="fas fa-cart-plus"></i></button>
                                                    </span>
                                                </span>
                                                <br/>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                </section>
                <section>
                    <span class="text-center"><h2>Recensioni</h2></span>
                    <?php
                    if (!$isSupplier) {
                        ?>
                        <form action="#" method="POST">
                            <div class="form-group">
                                <div class="pt-2">
                            		<input name="stars" class="rating rating-loading" data-min="0" data-max="5" data-step="0.5" value="4" data-size="lg" required>
                            	</div>
                                <label for="commentReview" class="font-weight-bold">Scrivi la tua recensione</label>
                                <textarea class="form-control" rows="5" id="commentReview" name="comment" placeholder="Che cosa ti è piaciuto e cosa non ti è piaciuto?" required></textarea>
                                <label for="titleReview" class="font-weight-bold" id="addTitleReview">Aggiungi un titolo</label>
                                <input type="text" class="form-control" id="titleReview" name="title" placeholder="Quali sono le cose più importanti da sapere?" required>
                                <button type="submit" class="btn btn-primary">Invia</button>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </section>
                <?php
            }
                ?>
        </div>
    </body>
</html>

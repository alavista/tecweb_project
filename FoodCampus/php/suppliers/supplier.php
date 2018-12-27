<?php require_once '../database.php';?>
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
         <!-- Plugin JQuery for cookies-->
         <script src="/tecweb_project/FoodCampus/jquery/jquery.cookie.js"></script>
         <!--JavaScript-->
         <script src="supplier.js" type="text/javascript"></script>
         <!--Font awesome-->
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <!--CSS-->
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../../css/navbar.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="supplier.css">
    </head>
    <body>
        <div class="container">
        <?php
            require_once '../navbar.php';
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $query_sql = "SELECT * FROM fornitore WHERE IDFornitore = '".$_GET['id']."'";
                $result = $conn->query($query_sql);
               	if ($result !== false && $result->num_rows > 0) {
                    $supplier = $result->fetch_assoc();
                    ?>
                    <div class="text-center" id="supplierName1">
                        <h1>
                            <span id="name"><?php echo strtoupper($supplier['nome']);?></span>
                            <?php
                            $supplierPage = false;
                            if (isset($_COOKIE["user_email"])) {
                                $supplierPage = $supplier["email"] == $_COOKIE["user_email"] ? true : false;
                                if ($supplierPage) {
                                    echo "<button type='button' class='btn btn-secondary' id='changeName'>Modifica nome</button>";
                                }
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="form-group text-center" id="supplierName2">
                        <label class="notVisible" for="newName">Nuovo nome</label><input type="text" id="newName" class='form-control' placeholder="Nuovo nome"/>
                        <button type='button' id="saveName" class='btn btn-success'>Salva</button>
                        <button type='button' id="cancelChangeName" class='btn btn-danger'>Annulla</button>
                    </div>
                    <img src="../../res/suppliers/<?php echo $supplier["immagine"] != NULL ? $supplier["immagine"] : 'default.jpg';?>" class="img-fluid img-thumbnail" alt="Logo fornitore">
                    <?php
                }
                    ?>
                <section>
                    <div class="jumbotron">
                        <span class="text-center"><h2>Informazioni</h2></span>
                        <div id="supplierCity1">
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">Città:</span>
                                    <p id="city"><?php echo $supplier["citta"];?></p>
                                </div>
                                <?php
                                if ($supplierPage) {
                                    echo "<div class='col-sm-7'>
                                              <button type='button' class='btn btn-secondary' id='changeCity'>Modifica città</button>
                                          </div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group text-center" id="supplierCity2">
                            <label class="notVisible" for="newCity">Nuova città</label><input type="text" id="newCity" class='form-control' placeholder="Nuova città"/>
                            <button type='button' id="saveCity" class='btn btn-success'>Salva</button>
                            <button type='button' id="cancelChangeCity" class='btn btn-danger'>Annulla</button>
                        </div>
                        <div id="supplierAddress1">
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">Indirizzo:</span>
                                    <p id="address"><?php echo $supplier["indirizzo_via"];?></p>
                                </div>
                                <?php
                                if ($supplierPage) {
                                    echo "<div class='col-sm-7'>
                                              <button type='button' class='btn btn-secondary' id='changeAddress'>Modifica indirizzo</button>
                                          </div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group text-center" id="supplierAddress2">
                            <label class="notVisible" for="newAddress">Nuovo indirizzo</label><input type="text" id="newAddress" class='form-control' placeholder="Nuovo indirizzo"/>
                            <button type='button' id="saveAddress" class='btn btn-success'>Salva</button>
                            <button type='button' id="cancelChangeAddress" class='btn btn-danger'>Annulla</button>
                        </div>
                        <div id="supplierHouseNumber1">
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">Numero civico:</span>
                                    <p id="houseNumber"><?php echo $supplier["indirizzo_numero_civico"];?></p>
                                </div>
                                <?php
                                if ($supplierPage) {
                                    echo "<div class='col-sm-7'>
                                              <button type='button' class='btn btn-secondary' id='changeHouseNumber'>Modifica numero civico</button>
                                          </div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group text-center" id="supplierHouseNumber2">
                            <label class="notVisible" for="newHouseNumber">Nuovo numero civico</label><input type="text" id="newHouseNumber" class='form-control' placeholder="Nuovo numero civico"/>
                            <button type='button' id="saveHouseNumber" class='btn btn-success'>Salva</button>
                            <button type='button' id="cancelChangeHouseNumber" class='btn btn-danger'>Annulla</button>
                        </div>
                        <div id="supplierShippingCosts1">
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">Costi di spedizione:</span>
                                    <p id="shippingCosts"><?php echo $supplier["costi_spedizione"];?> €</p>
                                </div>
                                <?php
                                if ($supplierPage) {
                                    echo "<div class='col-sm-7'>
                                              <button type='button' class='btn btn-secondary' id='changeShippingCosts'>Modifica costi di spedizione</button>
                                          </div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group text-center" id="supplierShippingCosts2">
                            <label class="notVisible" for="newShippingCosts">Nuovi costi spedizione</label><input type="text" id="newShippingCosts" class='form-control' placeholder="Nuovi costi spedizione"/>
                            <button type='button' id="saveShippingCosts" class='btn btn-success'>Salva</button>
                            <button type='button' id="cancelChangeShippingCosts" class='btn btn-danger'>Annulla</button>
                        </div>
                        <div id="supplierWebSite1">
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">Sito web:</span><br/>
                                    <a id="webSite" href="<?php echo $supplier["sito_web"];?>"><?php echo $supplier["sito_web"];?></a></p>
                                </div>
                                <?php
                                if ($supplierPage) {
                                    echo "<div class='col-sm-7'>
                                              <button type='button' class='btn btn-secondary' id='changeWebSite'>Modifica sito web</button>
                                          </div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group text-center" id="supplierWebSite2">
                            <label class="notVisible" for="newWebSite">Nuovo sito web</label><input type="text" id="newWebSite" class='form-control' placeholder="Nuovo sito web"/>
                            <button type='button' id="saveWebSite" class='btn btn-success'>Salva</button>
                            <button type='button' id="cancelChangeWebSite" class='btn btn-danger'>Annulla</button>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="jumbotron" id="menu">
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
                        <div>
                            <div class="form-group">
                                <div class="pt-2">
                            		<input name="stars" id="valutationReview" class="rating rating-loading" data-min="0" data-max="5" data-step="0.5" value="4" data-size="lg">
                                </div>
                                <label for="commentReview" class="font-weight-bold">Scrivi la tua recensione</label>
                                <textarea class="form-control" rows="5" id="commentReview" name="comment" placeholder="Che cosa ti è piaciuto e cosa non ti è piaciuto?" required></textarea>
                                <label for="titleReview" class="font-weight-bold" id="addTitleReview">Aggiungi un titolo</label>
                                <input type="text" class="form-control" id="titleReview" name="title" placeholder="Quali sono le cose più importanti da sapere?" required>
                                <button type="submit" id="submitReview" class="btn btn-primary">Invia</button>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col"><hr></div>
                    <?php
                    $query_sql = "SELECT COUNT(*) AS numberReview, AVG(valutazione) AS averageRating FROM recensione WHERE IDFornitore = '$supplier[IDFornitore]'";
                    $result = $conn->query($query_sql);
                    if ($result !== false && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        ?>
                        <p id="numberReview" class="font-weight-bold"><?php echo $row["numberReview"];?> recensioni clienti</p>
                        <input class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="<?php echo $row['averageRating'];?>" data-size="lg" data-showcaption=false disabled/>
                        <p id="averageRating"><?php echo number_format($row['averageRating'], 1);?> su 5 stelle</p>
                        <?php
                    }
                    ?>
                    <?php
                    $query_sql = "SELECT nome, cognome, immagine, titolo, commento, valutazione FROM recensione R, cliente C WHERE R.IDCliente = C.IDCliente AND R.IDFornitore = '$supplier[IDFornitore]'";
                    $result = $conn->query($query_sql);
                    if ($result !== false && $result->num_rows > 0) {
                        ?>
                        <div class="col"><hr></div>
                        <div class="mediasReviews">
                            <?php
                            while($row = $result->fetch_assoc()) {
                                ?>
                                <div class="media border p-3">
                                    <img src="../../res/clients/<?php echo $row["immagine"] != NULL ? $row["immagine"] : "default.png";?>" alt="<?php echo $row['nome'];?>" id="imageClient" class="mr-3 mt-3 rounded-circle">
                                    <div class="media-body">
                                        <input class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="<?php echo $row['valutazione'];?>" data-size="md" data-showcaption=false disabled>
                                        <span><?php echo $row['nome'];?></span>
                                        <span class="font-weight-bold"><?php echo $row["titolo"];?></span>
                                        <p><?php echo $row["commento"];?></p>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                        </div>
                        <?php
                    }
                    ?>
                </section>
                <?php
            }
            $conn->close();
                ?>
        </div>
    </body>
</html>

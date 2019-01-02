<div class="jumbotron" id="menu">
    <span class="text-center"><h2>Menù</h2></span>
    <h3>Listino<i class="fas fa-utensils"></i></h3>
    <?php
    $isSupplier = false;
    if (isset($_COOKIE["user_email"])) {
        $query="SELECT * FROM fornitore WHERE email = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $_COOKIE["user_email"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                $isSupplier = ($stmt->num_rows > 0) ? true : false;
            }
        }
    } else if ((!empty($_SESSION["user_type"])) && $_SESSION["user_type"] == "Fornitore") {
        $isSupplier = true;
    }
    if ($supplierPage) {
        $query="SELECT * FROM categoria";
        if ($stmt = $conn->prepare($query)) {
            if ($stmt->execute()) {
                $res = $stmt->get_result();
                if ($res->num_rows > 0) {
                    while ($category = $res->fetch_assoc()) {
                        ?>
                        <h4><?php echo ucwords($category["nome"]); ?></h4>
                        <?php
                        $query="SELECT * FROM prodotto WHERE IDFornitore = ? AND IDCategoria = ?";
                        if ($stmt = $conn->prepare($query)) {
                            $stmt->bind_param("ss", $idSupplier, $category["IDCategoria"]);
                            if ($stmt->execute()) {
                                $res1 = $stmt->get_result();
                                if ($res->num_rows > 0) {
                                    while ($product = $res1->fetch_assoc()) {
                                        ?>
                                        <div class="product" id="product_<?php echo $product['IDProdotto']; ?>">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <span id="productName_<?php echo $product['IDProdotto']; ?>"><?php echo $product['nome']; ?></span>: <span id="productCost_<?php echo $product['IDProdotto']; ?>"><?php echo $product["costo"]; ?></span> €
                                                </div>
                                                <div class='col-sm-7'>
                                                    <button type='button' id='changeProduct_<?php echo $product['IDProdotto']; ?>' class='btn btn-secondary changePlus changeProduct'>Modifica prodotto</button>
                                                </div>
                                            </div>
                                        </div>
                                        <form id="modificationProduct_<?php echo $product['IDProdotto']; ?>" class="text-center products">
                                            <div class="form-group">
                                                <label class="notVisible" for="newProductName_<?php echo $product['IDProdotto']; ?>">Nome prodotto</label>
                                                <input type="text" id="newProductName_<?php echo $product['IDProdotto']; ?>" class='form-control' placeholder="Nome prodotto"/>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">€</span>
                                                    </div>
                                                    <label class="notVisible" for="newProductCost_<?php echo $product['IDProdotto']; ?>">Costo prodotto</label>
                                                    <input type="number" value="0.00" min="0" step="0.01" data-number-to-fixed="2" class="form-control spedition" id="newProductCost_<?php echo $product['IDProdotto']; ?>" placeholder="Costo prodotto"/>
                                                </div>
                                                <div id="productError_<?php echo $product['IDProdotto']; ?>"></div>
                                            </div>
                                            <div class="form-group">
                                                <button type='button' id="saveProduct_<?php echo $product['IDProdotto']; ?>" class='btn btn-success change saveProduct'>Salva</button>
                                                <button type='button' id="cancelChangeProduct_<?php echo $product['IDProdotto']; ?>" class='btn btn-danger change cancelChangeProduct'>Annulla</button>
                                            </div>
                                        </form>
                                        <?php
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {
        $query="SELECT DISTINCT IDCategoria FROM prodotto WHERE IDFornitore = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $idSupplier);
            if ($stmt->execute()) {
                $res = $stmt->get_result();
                if ($res->num_rows > 0) {
                    while ($category = $res->fetch_assoc()) {
                        $idCategory = $category["IDCategoria"];
                        $query = "SELECT nome from categoria where IDCategoria = ?";
                        if ($stmt = $conn->prepare($query)) {
                            $stmt->bind_param("s", $idCategory);
                            if ($stmt->execute()) {
                                $res1 = $stmt->get_result();
                                if ($res1->num_rows > 0) {
                                    ?>
                                    <h4><?php echo ucwords($res1->fetch_assoc()["nome"]); ?></h4>
                                    <?php
                                    $query="SELECT nome, costo FROM prodotto WHERE IDFornitore = ? AND IDCategoria = ?";
                                    if ($stmt = $conn->prepare($query)) {
                                        $stmt->bind_param("ss", $idSupplier, $idCategory);
                                        if ($stmt->execute()) {
                                            $res2 = $stmt->get_result();
                                            if ($res2->num_rows > 0) {
                                                while ($product = $res2->fetch_assoc()) {
                                                ?>
                                                    <div class="product">
                                                        <span class="float-left"><?php echo $product["nome"]; ?></span>
                                                        <span class="float-right">
                                                            <span><?php echo $product["costo"]; ?> €</span>
                                                            <span <?php if ($isSupplier) { echo "data-toggle='popover' data-trigger='hover' data-content='I fornitori non possono acquistare'"; } ?>>
                                                                <button type="button" class="btn btn-deafult btn-kart" <?php if ($isSupplier) { echo "style='pointer-events: none;' disabled"; } ?>><i class="fas fa-cart-plus"></i></button>
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
                            }
                        }
                    }
                }
            }
        }
    }
    ?>
</div>

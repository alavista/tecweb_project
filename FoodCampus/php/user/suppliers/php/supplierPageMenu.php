<?php
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
                            ?>
                            <div id="ProductsOfCategory_<?php echo $category['IDCategoria']; ?>">
                                <?php
                                while ($product = $res1->fetch_assoc()) {
                                    ?>
                                    <div class="product" id="product_<?php echo $product['IDProdotto']; ?>">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <span id="productName_<?php echo $product['IDProdotto']; ?>"><?php echo $product['nome']; ?></span>
                                                <span id="productVegan_<?php echo $product['IDProdotto']; ?>">
                                                    <?php
                                                    if($product["vegano"]) {
                                                        ?>
                                                        <span class="font-italic"> (vegano)</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </span>
                                                <span id="productCeliac_<?php echo $product['IDProdotto']; ?>">
                                                    <?php
                                                    if($product["celiaco"]) {
                                                        ?>
                                                        <span class="font-italic"> (no glutine)</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </span>
                                                <span id="productFrozen_<?php echo $product['IDProdotto']; ?>">
                                                    <?php
                                                    if($product["surgelato"]) {
                                                        ?>
                                                        <span class="font-italic"> (surgelato)</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </span>
                                                : <span id="productCost_<?php echo $product['IDProdotto']; ?>"><?php echo $product["costo"]; ?></span> €
                                            </div>
                                            <div class='col-lg-4'>
                                                <button type='button' id='changeProduct_<?php echo $product['IDProdotto']; ?>' class='btn btn-secondary changePlus changeProduct'>Modifica prodotto</button>
                                            </div>
                                            <div class='col-lg-4'>
                                                <button type='button' id='deleteProduct_<?php echo $product['IDProdotto']; ?>' class='btn btn btn-danger change deleteProduct'>Cancella prodotto</button>
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
                                        <div class="form-check-inline">
                                            <div class="form-check">
                                                <label class="form-check-label" for="newProductVegan_<?php echo $product['IDProdotto']; ?>">
                                                    <input type="checkbox" class="form-check-input" id="newProductVegan_<?php echo $product['IDProdotto']; ?>" name="vegan" <?php if($product["vegano"]) { echo "checked"; } ?>>Vegano
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-check-inline">
                                            <div class="form-check">
                                                <label class="form-check-label" for="newProductCeliac_<?php echo $product['IDProdotto']; ?>">
                                                    <input type="checkbox" class="form-check-input" id="newProductCeliac_<?php echo $product['IDProdotto']; ?>" name="celiac" <?php if($product["celiaco"]) { echo "checked"; } ?>>No glutine
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-check-inline">
                                            <div class="form-check">
                                                <label class="form-check-label" for="newProductFrozen_<?php echo $product['IDProdotto']; ?>">
                                                    <input type="checkbox" class="form-check-input" id="newProductFrozen_<?php echo $product['IDProdotto']; ?>" name="frozen" <?php if($product["surgelato"]) { echo "checked"; } ?>>Surgelato
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type='button' id="saveProduct_<?php echo $product['IDProdotto']; ?>" class='btn btn-success change saveProduct'>Salva</button>
                                            <button type='button' id="cancelChangeProduct_<?php echo $product['IDProdotto']; ?>" class='btn btn-danger change cancelChangeProduct'>Annulla</button>
                                        </div>
                                    </form>
                                    <?php
                                }
                                ?>
                            </div>
                            <button type='button' id="addProductInCategory_<?php echo $category['IDCategoria']; ?>" class='btn btn-secondary change addNewProduct'>Aggiungi nuovo prodotto</button>
                            <form id="appendProductInCategory_<?php echo $category['IDCategoria']; ?>" class="text-center products">
                                <div class="form-group">
                                    <label class="notVisible" for="newProductNameInCategory_<?php echo $category['IDCategoria']; ?>">Nome nuovo prodotto</label>
                                    <input type="text" id="newProductNameInCategory_<?php echo $category['IDCategoria']; ?>" class='form-control' placeholder="Nome nuovo prodotto"/>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">€</span>
                                        </div>
                                        <label class="notVisible" for="newProductCostInCategory_<?php echo $category['IDCategoria']; ?>">Costo nuovo prodotto</label>
                                        <input type="number" value="0.00" min="0" step="0.01" data-number-to-fixed="2" class="form-control spedition" id="newProductCostInCategory_<?php echo $category['IDCategoria']; ?>" placeholder="Costo nuovo prodotto"/>
                                    </div>
                                    <div id="productErrorInCategory_<?php echo $category['IDCategoria']; ?>"></div>
                                </div>
                                <div class="form-check-inline">
                                    <div class="form-check">
                                        <label class="form-check-label" for="newProductVeganInCategory_<?php echo $category['IDCategoria']; ?>">
                                            <input type="checkbox" class="form-check-input" id="newProductVeganInCategory_<?php echo $category['IDCategoria']; ?>" name="vegan" <?php if($product["vegano"]) { echo "checked"; } ?>>Vegano
                                        </label>
                                    </div>
                                </div>
                                <div class="form-check-inline">
                                    <div class="form-check">
                                        <label class="form-check-label" for="newProductCeliacInCategory_<?php echo $category['IDCategoria']; ?>">
                                            <input type="checkbox" class="form-check-input" id="newProductCeliacInCategory_<?php echo $category['IDCategoria']; ?>" name="celiac" <?php if($product["celiaco"]) { echo "checked"; } ?>>No glutine
                                        </label>
                                    </div>
                                </div>
                                <div class="form-check-inline">
                                    <div class="form-check">
                                        <label class="form-check-label" for="newProductFrozenInCategory_<?php echo $category['IDCategoria']; ?>">
                                            <input type="checkbox" class="form-check-input" id="newProductFrozenInCategory_<?php echo $category['IDCategoria']; ?>" name="frozen" <?php if($product["surgelato"]) { echo "checked"; } ?>>Surgelato
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type='button' id="saveNewProductInCategory_<?php echo $category['IDCategoria']; ?>" class='btn btn-success change saveNewProduct'>Salva</button>
                                    <button type='button' id="cancelNewProductInCategory_<?php echo $category['IDCategoria']; ?>" class='btn btn-danger change cancelNewProduct'>Annulla</button>
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

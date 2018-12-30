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
                        }
                    }
                }
            }
        }
    }
    ?>
</div>

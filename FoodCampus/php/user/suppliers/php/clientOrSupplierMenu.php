<?php
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
                            $query="SELECT * FROM prodotto WHERE IDFornitore = ? AND IDCategoria = ?";
                            if ($stmt = $conn->prepare($query)) {
                                $stmt->bind_param("ss", $idSupplier, $idCategory);
                                if ($stmt->execute()) {
                                    $res2 = $stmt->get_result();
                                    if ($res2->num_rows > 0) {
                                        while ($product = $res2->fetch_assoc()) {
                                        ?>
                                            <div class="row product">
                                                <span class="col-lg-9">
                                                    <?php
                                                    echo $product["nome"];
                                                    if ($product["vegano"] || $product["celiaco"] || $product["surgelato"]) {
                                                        ?>
                                                        <span class="font-italic">
                                                            <?php
                                                            if ($product["vegano"]) {
                                                                echo " (vegano)";
                                                            }
                                                            if ($product["celiaco"]) {
                                                                echo " (celiaco)";
                                                            }
                                                            if ($product["surgelato"]) {
                                                                echo " (surgelato)";
                                                            }
                                                            ?>
                                                        </span>
                                                        <?php
                                                    }
                                                    ?>
                                                </span>
                                                <span class="col-lg-3">
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
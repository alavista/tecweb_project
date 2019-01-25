<div class="jumbotron" id="menu">
    <h2 class="text-center">Menù</h2>
    <h3>Listino<strong class="fas fa-utensils"></strong></h3>
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
        require_once 'supplierPageMenu.php';
    } else {
        require_once 'clientOrSupplierMenu.php';
    }
    ?>
</div>

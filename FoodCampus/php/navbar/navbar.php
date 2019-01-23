<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/tecweb_project/FoodCampus/php/database.php";
require_once "$root/tecweb_project/FoodCampus/php/utilities/direct_login.php";
require_once "$root/tecweb_project/FoodCampus/php/utilities/secure_session.php";
require_once "$root/tecweb_project/FoodCampus/php/navbar/navbar_research.php";
//sec_session_start();


function computeNumberNotification($conn, $field, $userId) {
    $query = "SELECT COUNT(*) as notificationNumber FROM notifica WHERE $field = ? AND visualizzata = ?";
    if ($stmt = $conn->prepare($query)) {
        $notificationDisplayes = false;
        $stmt->bind_param("ii", $userId, $notificationDisplayes);
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                return $res->fetch_assoc()["notificationNumber"];
            }
        }
    }
    return 0;
}

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION["page"] = $actual_link;

$loggedInUser = isUserLogged($conn);
$supplier = false;
if ($loggedInUser) {
    if (!empty($_SESSION["user_id"]) && !empty($_SESSION["user_type"])) {
        $supplier = $_SESSION["user_type"] == "Fornitore" ? true : false;
        $userId = $_SESSION["user_id"];
    } else if (isset($_COOKIE["user_id"]) && isset($_COOKIE["user_type"])) {
        $supplier = strcmp($_COOKIE["user_type"], "Fornitore") == 0 ? true : false;
        $userId = $_COOKIE["user_id"];
    }
    if (!$supplier) {
        $notificationNumber = computeNumberNotification($conn, 'IDCliente', $userId);
        /*$query = "SELECT COUNT(*) as productsNumber FROM prodotto_in_carrello WHERE IDCliente = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $userId);
            if ($stmt->execute()) {
                $res = $stmt->get_result();
                if ($res->num_rows > 0) {
                    $productsNumber = $res->fetch_assoc()["productsNumber"];
                    $notificationNumber = computeNumberNotification($conn, 'IDCliente', $userId);
                }
            }
        }*/
    } else {
        $notificationNumber = computeNumberNotification($conn, 'IDFornitore', $userId);
    }
}
?>

<nav class="navbar navbar-expand-xl navbar-dark fixed-top navbar-custom">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link item" href="/tecweb_project/FoodCampus/php/home/home.php">Home</a></li>
            <li class="nav-item"><a class="nav-link item" href="/tecweb_project/FoodCampus/php/products_research/products_research_index.php">Ricerca prodotti</a></li>
            <li class="nav-item"><a class="nav-link item" href="/tecweb_project/FoodCampus/php/suppliers_research/suppliers_research_index.php">Ricerca fornitori</a></li>
            <?php
            if ($loggedInUser) {
                ?>
                <li class="nav-item"><a class="nav-link item" href=<?php if ($supplier) { echo "/tecweb_project/FoodCampus/php/user/suppliers/php/supplier.php?id=".$userId; } else {echo "/tecweb_project/FoodCampus/php/user/client/client.php?id=".$userId;} ?>>Profilo</a></li>
                <?php
            }
            ?>
            <li class="nav-item"><a class="nav-link item" href="<?php if (!$loggedInUser) { echo '/tecweb_project/FoodCampus/php/login/login.php'; } else { echo '/tecweb_project/FoodCampus/php/logout.php'; } ?>"><?php if (!$loggedInUser) { echo "Login"; } else { echo "Logout"; } ?></a></li>
            <?php
            if ($loggedInUser) {
                ?>
                <li class="nav-item dropdown">
                    <span id="numberNotification" class='badge badge-light'><?php echo $notificationNumber ?></span>
                    <a class="nav-link fas fa-bell item" href="#" id="notification" data-toggle="dropdown"></a>
                    <div class="dropdown-menu">
                        <?php
                        $fieldId = $supplier ? "IDFornitore" : "IDCliente";
                        $notificationTitle = $fieldId == "IDFornitore" ? "Nuovo ordine" : "Ordine partito";
                        $query = "SELECT * FROM notifica WHERE $fieldId = ? ORDER BY IDNotifica DESC LIMIT 5";
                        if ($stmt = $conn->prepare($query)) {
                            $stmt->bind_param("i", $userId);
                            if ($stmt->execute()) {
                                $res = $stmt->get_result();
                                if ($res->num_rows > 0) {
                                    $notification = '';
                                    while($row = $res->fetch_assoc()) {
                                        if ($supplier) {
                                            echo '<a class="dropdown-item" href=/tecweb_project/FoodCampus/php/supplier_orders/supplier-orders.php?id='.$userId.'><strong>'.$notificationTitle.'</strong><br/><small><em>'.$row["testo"].'</em></small></a>';
                                        } else {
                                            echo '<span class="dropdown-item"><strong>'.$notificationTitle.'</strong><br/><small><em>'.$row["testo"].'</em></small></span>';
                                        }
                                    }
                                    $pathForSeeAllNotifications = "/tecweb_project/FoodCampus/php/notifications/notifications.php?id=$userId";
                                    echo '<a class="dropdown-item" href="'.$pathForSeeAllNotifications.'"><strong>Tutte le notifiche</strong><br/><small><em>Clicca qui per vedere tutte le notifiche</em></small></a>';
                                } else {
                                    echo '<span class="dropdown-item text-bold text-italic">Non hai nessuna notifica!</span>';
                                }
                            }
                        }
                        ?>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>

    <form class="mx-2 my-auto form-inline w-50" id="search-form">
       <div class="input-group global-research">
           <script src="/tecweb_project/FoodCampus/php/navbar/navbar_research.js"></script>
           <script src="/tecweb_project/FoodCampus/php/user/suppliers/js/supplierFunctions.js"></script>
           <link rel="stylesheet" type="text/css" title="stylesheet" href="/tecweb_project/FoodCampus/php/user/suppliers/css/starReview.css">

            <input id="navbar-search" class="form-control searchit" type="text" placeholder="Cerca...">
            <label class='hidden' for="navbar-search">Ricerca globale</label>
            <ul class="list-group searchit" id="result"></ul>
        </div>
    </form>

    <ul id="cart" class="navbar-nav">
        <?php

            if ($supplier) {
                ?>
                    <li class="nav-item"><a class="nav-link item" href="/tecweb_project/FoodCampus/php/supplier_orders/supplier-orders.php?id=<?php echo $userId; ?>">I miei ordini</a></li>
                <?php
            } else {
                $value = 0;
                if(isset($_SESSION["cart_filled"]) && isset($_SESSION["cart"])) {
                    foreach ($_SESSION["cart"] as $key => $n) {
                        if(!empty($key)) {
                            $value += $n;
                        }
                    }
                }
                echo "<li class='nav-item'><span id='prod-num' class='badge badge-light'>$value</span><a role='button' href='/tecweb_project/FoodCampus/php/cart/cart.php'  id='kart' class='btn fas fa-shopping-cart item' href'#'></a></li>";
            }
        ?>
    </ul>
</nav>

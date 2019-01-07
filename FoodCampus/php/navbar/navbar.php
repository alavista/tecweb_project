<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/tecweb_project/FoodCampus/php/database.php";
require_once "$root/tecweb_project/FoodCampus/php/utilities/direct_login.php";

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

/*function isStuck($conn, $table, $field, $userId) {
    $query = "SELECT bloccato FROM $table WHERE $field = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                return $res->fetch_assoc()["bloccato"];
            }
        }
    }
    return false;
}*/

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
    /*if (isStuck($conn, $supplier ? "fornitore" : "cliente", $supplier ? "IDFornitore" : "IDCliente", $userId)) {
        //echo "<script>alert('Success!');</script>";
        //header("Location: $root/tecweb_project/FoodCampus/php/logout.php");
    }*/
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
} else {
    //header("Location: $root/tecweb_project/FoodCampus/php/logout.php");
}
?>

<nav class="navbar navbar-expand-xl navbar-dark fixed-top navbar-custom">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="/tecweb_project/FoodCampus/php/home.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="/tecweb_project/FoodCampus/php/products_research/products_research_index.php">Ricerca prodotti</a></li>
            <li class="nav-item"><a class="nav-link" href="/tecweb_project/FoodCampus/php/suppliers_research/suppliers_research_index.php">Ricerca fornitori</a></li>
            <?php
            if ($loggedInUser) {
                ?>
                <li class="nav-item"><a class="nav-link" href=<?php if ($supplier) { echo "/tecweb_project/FoodCampus/php/suppliers/php/supplier.php?id=".$userId; } else {} ?>>Profilo</a></li>
                <?php
            }
            ?>
            <li class="nav-item"><a class="nav-link" href="<?php if (!$loggedInUser) { echo '/tecweb_project/FoodCampus/php/login/login.php'; } else { echo '/tecweb_project/FoodCampus/php/logout.php'; } ?>"><?php if (!$loggedInUser) { echo "Login"; } else { echo "Logout"; } ?></a></li>
            <?php
            if ($loggedInUser && !$supplier) {
                echo "<li class='nav-item'><span class='badge badge-light'>$notificationNumber</span><a id='notification' class='nav-link fas fa-bell' href='#'></a></li>";
            }
            ?>
        </ul>
    </div>
    <form class="form-inline" action="#">
        <div class="input-group abs-center-x">
            <input class="form-control" type="text" placeholder="Search">
            <div class="input-group-prepend">
                <button class="btn btn-default fas fa-search" type="submit"></button>
            </div>
        </div>
    </form>
    <ul class="navbar-nav">
        <?php
        if ($loggedInUser && !$supplier) {
            //NUMERO PRODOTTI DELL UTENTE NEL CARRELO....DA VERIFICARE NEI COOKIE/SESSIONE
            $value = 0;
        } else if($loggedInUser && $supplier) {
            $value = $notificationNumber;
        } else {
            $value = 0;
            //value = impostare il numero di prodotti quando l utente non e loggato
        }
        ?>
        <li class="nav-item"><span class="badge badge-light"><?php echo $value;?></span><a id=<?php echo $supplier ? "notification" : "kart";?> class="nav-link <?php echo $supplier ? 'fas fa-bell' : 'fas fa-shopping-cart'?>" href="#"></a></li>
    </ul>
</nav>

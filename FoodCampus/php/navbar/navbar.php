<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/tecweb_project/FoodCampus/php/database.php";
require_once "$root/tecweb_project/FoodCampus/php/utilities/direct_login.php";

$loggedInUser = isUserLogged($conn);
$supplier = false;
if ($loggedInUser) {
    if (!empty($_SESSION["user_id"]) && !empty($_SESSION["user_type"])) {
        $supplier = $_SESSION["user_type"] == "Fornitore" ? true : false;
        $id = $_SESSION["user_id"];
    } else if (isset($_COOKIE["user_id"]) && isset($_COOKIE["user_type"])) {
        $supplier = strcmp($_COOKIE["user_type"], "Fornitore") == 0 ? true : false;
        $id = $_COOKIE["user_id"];
    }
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
                <li class="nav-item"><a class="nav-link" href=<?php if ($supplier) { echo "/tecweb_project/FoodCampus/php/suppliers/php/supplier.php?id=".$id; } else {} ?>>Profilo</a></li>
                <?php
            }
            ?>
            <li class="nav-item"><a class="nav-link" href="<?php if (!$loggedInUser) { echo '/tecweb_project/FoodCampus/php/login/login.php'; } else { echo '/tecweb_project/FoodCampus/php/logout.php'; } ?>"><?php if (!$loggedInUser) { echo "Login"; } else { echo "Logout"; } ?></a></li>
            <?php
            if (!$supplier) {
                echo "<li class='nav-item'><span class='badge badge-light'>0</span><a id='notification' class='nav-link fas fa-bell' href='#'></a></li>";
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
    <?php
    if ($supplier) {
        ?>
        <ul class="navbar-nav">
            <li class="nav-item"><span class="badge badge-light">0</span><a id="notification" class="nav-link fas fa-bell" href="#"></a></li>
        </ul>
        <?php
    } else {
        ?>
        <ul class="navbar-nav">
            <li class="nav-item"><span class="badge badge-light">0</span><a id="kart" class="nav-link fas fa-shopping-cart" href="#"></a></li>
        </ul>
        <?php
    }
    ?>
</nav>

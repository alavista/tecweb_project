<?php
    require_once '../../database.php';
    require_once "../../utilities/direct_login.php";

    //setcookie("user_email", "butterfly@gmail.com", time() + (86400 * 30)); //30 giorni
?>

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
         <script src="../../../jquery/jquery.cookie.js"></script>
         <!-- Plugin JQuery for sessions-->
         <script src="../../../jquery/jquery.session.js"></script>
         <!--JavaScript-->
         <script src="../js/supplierFunctions.js" type="text/javascript"></script>
         <script src="../js/supplier.js" type="text/javascript"></script>
         <script src="../../../js/utilities/sha512.js" type="text/javascript"></script>
         <script src="../js/name.js" type="text/javascript"></script>
         <script src="../js/email.js" type="text/javascript"></script>
         <script src="../js/password.js" type="text/javascript"></script>
         <script src="../js/city.js" type="text/javascript"></script>
         <script src="../js/addressVia.js" type="text/javascript"></script>
         <script src="../js/addressHouseNumber.js" type="text/javascript"></script>
         <script src="../js/shippingCosts.js" type="text/javascript"></script>
         <script src="../js/webSite.js" type="text/javascript"></script>
         <script src="../js/review.js" type="text/javascript"></script>
         <!--Font awesome-->
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <!--CSS-->
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../../../css/navbar.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../css/supplier.css">
    </head>
    <body>
        <div class="container">
        <?php
            require_once '../../navbar.php';
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET["id"]) &&
                    is_numeric($_GET["id"]) && ctype_digit($_GET["id"]) && $_GET["id"] >= 0) {
                require_once 'notehead.php';
                ?>
                <section>
                    <?php require_once 'information.php'; ?>
                </section>
                <section>
                    <?php require_once 'menu.php'; ?>
                </section>
                <section>
                    <?php require_once 'reviews.php'; ?>
                </section>
                <?php
            } else {
                die("Supplier not found!");
            }
            $conn->close();
            ?>
        </div>
    </body>
</html>

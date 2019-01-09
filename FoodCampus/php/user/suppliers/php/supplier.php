<?php
    require_once '../../../database.php';
    require_once "../../../utilities/direct_login.php";

    function redirectToPageNotFound($conn) {
        header("Location: /tecweb_project/FoodCampus/php/pageNotFound.html");
        $conn->close();
        exit();
    }
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
         <script src="../../../../jquery/jquery.cookie.js"></script>
         <!-- Plugin JQuery for sessions-->
         <script src="../../../../jquery/jquery.session.js"></script>
         <!-- Plugin JQuery for alert-->
         <script src="../../../../jquery/jquery-confirm.min.js" type="text/javascript"></script>
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../../../../css/jquery-confirm.min.css">
         <!--JavaScript-->
         <script src="../js/supplierFunctions.js" type="text/javascript"></script>
         <script src="../js/supplier.js" type="text/javascript"></script>
         <script src="../../../../js/utilities/sha512.js" type="text/javascript"></script>
         <script src="../../commonParts/js/user.js" type="text/javascript"></script>
         <script src="../../commonParts/js/userFunctions.js" type="text/javascript"></script>
         <script src="../../commonParts/js/name.js" type="text/javascript"></script>
         <script src="../../commonParts/js/password.js" type="text/javascript"></script>
         <script src="../../commonParts/js/image.js" type="text/javascript"></script>
         <script src="../../commonParts/js/email.js" type="text/javascript"></script>
         <script src="../js/city.js" type="text/javascript"></script>
         <script src="../js/addressVia.js" type="text/javascript"></script>
         <script src="../js/addressHouseNumber.js" type="text/javascript"></script>
         <script src="../js/shippingCosts.js" type="text/javascript"></script>
         <script src="../js/webSite.js" type="text/javascript"></script>
         <script src="../js/review.js" type="text/javascript"></script>
         <script src="../js/product.js" type="text/javascript"></script>
         <script src="../js/vatNumber.js" type="text/javascript"></script>
         <!--Font awesome-->
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <!--CSS-->
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../../../navbar/navbar.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../css/supplier.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../css/starReview.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../../../../css/utilities.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../../commonParts/css/user.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../../../../css/utilities.css">
    </head>
    <body>
        <div class="container">
        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET["id"]) &&
                    is_numeric($_GET["id"]) && ctype_digit($_GET["id"]) && $_GET["id"] >= 0) {
                $query = "SELECT * FROM fornitore WHERE IDFornitore = ?";
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("s", $_GET["id"]);
                    if ($stmt->execute()) {
                        $res = $stmt->get_result();
                        if ($res->num_rows == 1) {
                            require_once '../../../navbar/navbar.php';
                            require_once 'notehead.php';
                            ?>
                            <section>
                                <?php require_once 'informations.php'; ?>
                            </section>
                            <section>
                                <?php require_once 'menu.php'; ?>
                            </section>
                            <section>
                                <?php require_once 'reviews.php'; ?>
                            </section>
                            <?php
                        } else {
                            redirectToPageNotFound($conn);
                        }
                    }
                }
            } else {
                redirectToPageNotFound($conn);
            }
            $conn->close();
            ?>
        </div>
    </body>
</html>
<?php
    require_once "../../../utilities/direct_login.php";

    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["idSupplier"]) && isset($_POST["title"]) &&
            isset($_POST["comment"]) && isset($_POST["valutation"]) &&
            $_POST["idSupplier"] >= 0) {
        $_SESSION['idSupplierForReview'] = $_POST['idSupplier'];
        $_SESSION['titleReview'] = $_POST['title'];
        $_SESSION['commentReview'] = $_POST['comment'];
        $_SESSION['valutationReview'] = $_POST['valutation'];
        $_SESSION['validReview'] = "yes";
        $informationToSendClient["status"] = "OK";
        $informationToSendClient["inf"] = "OK";
    } else {
        $informationToSendClient["status"] = "ERROR";
        $informationToSendClient["inf"] = "parametriNonCorretti";
    }
    echo json_encode($informationToSendClient);
?>

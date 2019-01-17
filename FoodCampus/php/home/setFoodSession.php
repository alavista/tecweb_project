<?php
    require_once '../utilities/direct_login.php';

    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["food"])) {
        $_SESSION["food"] = $_POST["food"];
        $informationToSendClient["status"] = "OK";
        $informationToSendClient["inf"] = "OK";
    } else {
        $informationToSendClient["status"] = "ERROR";
        $informationToSendClient["inf"] = "Parametri non corretti!";
    }
    echo json_encode($informationToSendClient);

?>

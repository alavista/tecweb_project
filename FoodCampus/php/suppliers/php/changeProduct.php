<?php
    require_once '../../database.php';

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["idProduct"]) && isset($_POST["productName"]) && isset($_POST["productCost"]) &&
    (!empty($_POST["productName"]) && !strlen(trim($_POST["productName"])) == 0) &&
    $_POST["productCost"] > 0 && $_POST["idProduct"] >= 0) {
        $query = "UPDATE prodotto SET nome = ?, costo = ? WHERE IDProdotto = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("sss", $_POST["productName"], $_POST["productCost"], $_POST["idProduct"]);
            if ($stmt->execute()) {
                $informationToSendClient["status"] = "OK";
                $informationToSendClient["inf"] = "OK";
            } else {
                $queryError = true;
            }
        } else {
            $queryError = true;
        }
    } else {
        $informationToSendClient["status"] = "ERROR";
        $informationToSendClient["inf"] = "parametriNonCorretti";
    }
    if ($queryError) {
        $informationToSendClient["status"] = "ERROR";
        $informationToSendClient["inf"] = "errore";
    }
    $conn->close();
    echo json_encode($informationToSendClient);

?>

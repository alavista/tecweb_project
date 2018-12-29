<?php
    require_once '../../database.php';

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["idSupplier"]) && isset($_POST["information"]) && isset($_POST["attribute"]) && (!empty($_POST["information"]) &&
            !strlen(trim($_POST["information"])) == 0) && (!empty($_POST["attribute"]) &&
                    !strlen(trim($_POST["attribute"])) == 0) && $_POST["idSupplier"] >= 0) {
        $attribute = $_POST['attribute'];
        $information = $_POST['information'];
        $query = "UPDATE fornitore SET $attribute = ? WHERE IDFornitore = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ss", $information, $_POST["idSupplier"]);
            if ($stmt->execute()) {
                $informationToSendClient["status"] = "OK";
                $informationToSendClient["inf"] = "$information";
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

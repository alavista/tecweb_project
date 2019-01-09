<?php
    require_once '../../../database.php';

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["userId"]) && isset($_POST["information"]) && isset($_POST["table"])
            && isset($_POST["attribute"]) && (!empty($_POST["information"]) &&
            !strlen(trim($_POST["information"])) == 0) && (!empty($_POST["table"]) &&
            !strlen(trim($_POST["table"])) == 0) && (!empty($_POST["attribute"]) &&
            !strlen(trim($_POST["attribute"])) == 0) && $_POST["userId"] >= 0) {
        $table = $_POST["table"];
        $attribute = $_POST['attribute'];
        $information = $_POST['information'];
        $fieldId = $table == "fornitore" ? "IDFornitore" : "IDCliente";
        $query = "UPDATE $table SET $attribute = ? WHERE $fieldId = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ss", $information, $_POST["userId"]);
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

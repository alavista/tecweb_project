<?php
    require_once '../database.php';

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["idSupplier"]) && isset($_POST["information"]) && isset($_POST["attribute"]) && (!empty($_POST["information"]) &&
            !strlen(trim($_POST["information"])) == 0) && (!empty($_POST["attribute"]) &&
            !strlen(trim($_POST["attribute"]))) == 0 && $_POST["idSupplier"] >= 0) {
        if (filter_var($_POST["information"], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['attribute'];
            $newEmail = $_POST['information'];
            $query = "SELECT * FROM fornitore WHERE email = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("s", $newEmail);
                if ($stmt->execute()) {
                    $res = $stmt->get_result();
                    if ($res->num_rows == 0) {
                        $query = "UPDATE fornitore SET $email = ? WHERE IDFornitore = ?";
                        if ($stmt = $conn->prepare($query)) {
                            $stmt->bind_param("ss", $newEmail, $_POST["idSupplier"]);
                            if ($stmt->execute()) {
                                $informationToSendClient["status"] = "OK";
                                $informationToSendClient["inf"] = "$newEmail";
                            } else {
                                $queryError = true;
                            }
                        } else {
                            $queryError = true;
                        }
                    } else {
                        $informationToSendClient["status"] = "ERROR";
                        $informationToSendClient["inf"] = "emailEsistente";
                    }
                } else {
                    $queryError = true;
                }
            } else {
                $queryError = true;
            }
        } else {
            $informationToSendClient["status"] = "ERROR";
            $informationToSendClient["inf"] = "emailNonValida";
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

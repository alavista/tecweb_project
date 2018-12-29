<?php
    require_once '../../database.php';

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["idSupplier"]) &&  isset($_POST["oldEncryptedPassword"]) &&
            isset($_POST["newEncryptedPassword"]) && isset($_POST["repetNewEncryptedPassword"]) &&
            $_POST["idSupplier"] >= 0) {
        $query = "SELECT password, salt FROM fornitore WHERE IDFornitore = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $_POST["idSupplier"]);
            if ($stmt->execute()) {
                $res = $stmt->get_result();
                if ($res->num_rows == 1) {
                    $inf = $res->fetch_assoc();
                    $oldPassword = $_POST["oldEncryptedPassword"];
                    $oldPassword = hash('sha512', $oldPassword.$inf["salt"]);
                    if (strcmp($oldPassword, $inf["password"]) == 0) {
                        if (strcmp($_POST["newEncryptedPassword"], $_POST["repetNewEncryptedPassword"]) == 0) {
                            $newPassword = hash('sha512', $_POST["newEncryptedPassword"].$inf["salt"]);
                            $query = "UPDATE fornitore SET password = ? WHERE IDFornitore = ?";
                            if ($stmt = $conn->prepare($query)) {
                                $stmt->bind_param("ss", $newPassword, $_POST["idSupplier"]);
                                if ($stmt->execute()) {
                                    $informationToSendClient["status"] = "OK";
                                    $informationToSendClient["inf"] = "La password è stata cambiata con successo!";
                                } else {
                                    $queryError = true;
                                }
                            } else {
                                $queryError = true;
                            }
                        } else {
                            $informationToSendClient["status"] = "ERROR";
                            $informationToSendClient["inf"] = "passwordsNotMatch";
                        }
                    } else {
                        $informationToSendClient["status"] = "ERROR";
                        $informationToSendClient["inf"] = "oldPasswordNotOk";
                    }
                } else {
                    $queryError = true;
                }
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

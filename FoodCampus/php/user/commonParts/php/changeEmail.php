<?php
    require_once '../../../database.php';
    require_once '../../../utilities/direct_login.php';

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["userId"]) && isset($_POST["information"]) && isset($_POST["attribute"]) &&
            isset($_POST["attribute"]) && (!empty($_POST["information"]) &&
            !strlen(trim($_POST["information"])) == 0) && (!empty($_POST["table"]) &&
            !strlen(trim($_POST["table"])) == 0) && (!empty($_POST["attribute"]) &&
            !strlen(trim($_POST["attribute"]))) == 0 && $_POST["userId"] >= 0) {
        if (filter_var($_POST["information"], FILTER_VALIDATE_EMAIL)) {
            $table = $_POST["table"];
            $email = $_POST['attribute'];
            $newEmail = $_POST['information'];
            $query = "SELECT * FROM $table WHERE email = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("s", $newEmail);
                if ($stmt->execute()) {
                    $res = $stmt->get_result();
                    if ($res->num_rows == 0) {
                        $fieldId = $table == "fornitore" ? "IDFornitore" : "IDCliente";
                        $query = "UPDATE $table SET $email = ? WHERE $fieldId = ?";
                        if ($stmt = $conn->prepare($query)) {
                            $stmt->bind_param("ss", $newEmail, $_POST["userId"]);
                            if ($stmt->execute()) {
                                if (isset($_COOKIE[$GLOBALS["cookie_user_email"]])) {
                                    setcookie($GLOBALS["cookie_user_email"], $newEmail, time() + (86400 * 365 * 5), "/");
                                }
                                if (!empty($_SESSION["email"])) {
                                    $_SESSION['email'] = $newEmail;
                                }
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

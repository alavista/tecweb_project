<?php
    require_once '../../../database.php';
    require_once '../../../utilities/direct_login.php';

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["userId"]) && isset($_POST["table"]) && isset($_POST["oldEncryptedPassword"]) &&
            isset($_POST["newEncryptedPassword"]) && isset($_POST["repetNewEncryptedPassword"]) &&
            (!empty($_POST["table"]) &&
            !strlen(trim($_POST["table"])) == 0) && $_POST["userId"] >= 0) {
        $table = $_POST["table"];
        $fieldId = $table == "fornitore" ? "IDFornitore" : "IDCliente";
        $query = "SELECT password, salt FROM $table WHERE $fieldId = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $_POST["userId"]);
            if ($stmt->execute()) {
                $res = $stmt->get_result();
                if ($res->num_rows == 1) {
                    $inf = $res->fetch_assoc();
                    $oldPassword = $_POST["oldEncryptedPassword"];
                    $oldPassword = hash('sha512', $oldPassword.$inf["salt"]);
                    if (strcmp($oldPassword, $inf["password"]) == 0) {
                        if (strcmp($_POST["newEncryptedPassword"], $_POST["repetNewEncryptedPassword"]) == 0) {
                            $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                            $newPassword = hash('sha512', $_POST["newEncryptedPassword"].$random_salt);
                            $query = "UPDATE $table SET password = ?, salt = ? WHERE $fieldId = ?";
                            if ($stmt = $conn->prepare($query)) {
                                $stmt->bind_param("sss", $newPassword, $random_salt, $_POST["userId"]);
                                if ($stmt->execute()) {
                                    if (isset($_COOKIE[$GLOBALS["cookie_user_password"]])) {
                                        setcookie($GLOBALS["cookie_user_password"], $newPassword, time() + (86400 * 365 * 5), "/");
                                    }
                                    if (!empty($_SESSION["login_string"])) {
                                        $_SESSION['login_string'] = hash('sha512', $newPassword.$_SERVER['HTTP_USER_AGENT']);
                                    }
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

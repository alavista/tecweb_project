<?php
    require_once '../../../database.php';
    require_once "../../../utilities/direct_login.php";
    require_once '../../../utilities/file_uploader.php';

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"])) {
        $userId = -1;
        $table = "";
        if (isset($_COOKIE["user_id"]) && isset($_COOKIE["user_type"])) {
            $userId = $_COOKIE["user_id"];
            $table = $_COOKIE["user_type"];
        } else if (!empty($_SESSION["user_id"]) && !empty($_SESSION["user_type"])) {
            $userId = $_SESSION["user_id"];
            $table = $_SESSION["user_type"] == "Fornitore" ? "fornitore" : "cliente";
        }
        if ($userId >= 0 && $table != "") {
            $fieldId = $table == "fornitore" ? "IDFornitore" : "IDCliente";
            /* Getting file name */
            $fileName =  basename($_FILES["file"]["name"]);
            $tempArrayName = explode(".", $fileName);
            $GLOBALS["newFileName"] = $tempArrayName[0].uniqid(mt_rand(1, mt_getrandmax()), false).".".$tempArrayName[1];
            $filePath = $table == "fornitore" ? "../../../../res/suppliers/" : "../../../../res/clients/";
            $fileError = "";
            if (uploadFile($filePath, $GLOBALS["newFileName"], "file", $fileError)) {
                $query = "SELECT immagine FROM $table WHERE $fieldId = ?";
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("s", $userId);
                    if ($stmt->execute()) {
                        $res = $stmt->get_result();
                        if ($res->num_rows == 1) {
                            $oldImage = $res->fetch_assoc()["immagine"];
                            $completePathOldImage = $filePath.$oldImage;
                            $query = "UPDATE $table SET immagine = ? WHERE $fieldId = ?";
                            if ($stmt = $conn->prepare($query)) {
                                $stmt->bind_param("ss", $GLOBALS["newFileName"], $userId);
                                if ($stmt->execute()) {
                                    $informationToSendClient["status"] = "OK";
                                    $informationToSendClient["inf"] = "".$GLOBALS["newFileName"];
                                    if (strcmp($oldImage, "") != 0) {
                                        unlink("$completePathOldImage");
                                    }
                                } else {
                                    $informationToSendClient["status"] = "ERROR";
                                    $informationToSendClient["inf"] = "Errore. Riprova più tardi!1";
                                }
                            } else {
                                $informationToSendClient["status"] = "ERROR";
                                $informationToSendClient["inf"] = "Errore. Riprova più tardi!2";
                            }
                        } else {
                            $informationToSendClient["status"] = "ERROR";
                            $informationToSendClient["inf"] = "Errore. Riprova più tardi!3";
                        }
                    } else {
                        $informationToSendClient["status"] = "ERROR";
                        $informationToSendClient["inf"] = "Errore. Riprova più tardi!4";
                    }
                } else {
                    $informationToSendClient["status"] = "ERROR";
                    $informationToSendClient["inf"] = "$table";
                }
            } else {
                $informationToSendClient["status"] = "ERROR";
                $informationToSendClient["inf"] = "$fileError";
            }
        } else {
            $informationToSendClient["status"] = "ERROR";
            $informationToSendClient["inf"] = "Parametri non corretti!";
        }
    } else {
        $informationToSendClient["status"] = "ERROR";
        $informationToSendClient["inf"] = "Il file non è un'immagine!";
    }
    if ($queryError) {
        $informationToSendClient["status"] = "ERROR";
        $informationToSendClient["inf"] = "Errore. Riprova più tardi!";
    }
    echo json_encode($informationToSendClient);
?>

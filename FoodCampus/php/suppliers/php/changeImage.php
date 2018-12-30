<?php
    require_once '../../database.php';
    require_once "../../utilities/direct_login.php";
    require_once '../../utilities/file_uploader.php';

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"])) {
        $idSupplier = -1;
        if (isset($_COOKIE["user_id"])) {
            $idSupplier = $_COOKIE["user_id"];
        } else if (!empty($_SESSION["user_id"])) {
            $idSupplier = $_SESSION["user_id"];
        }
        if ($idSupplier >= 0) {
            /* Getting file name */
            $fileName =  basename($_FILES["file"]["name"]);
            $tempArrayName = explode(".", $fileName);
            $GLOBALS["newFileName"] = $tempArrayName[0].uniqid(mt_rand(1, mt_getrandmax()), false).".".$tempArrayName[1];
            $filePath = "../../../res/suppliers/";
            $completeFilePath = $filePath.$GLOBALS["newFileName"];
            $fileError = "";
            if (uploadFile($filePath, $GLOBALS["newFileName"], "file", $fileError)) {
                $query = "SELECT immagine FROM fornitore WHERE IDFornitore = ?";
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("s", $idSupplier);
                    if ($stmt->execute()) {
                        $res = $stmt->get_result();
                        if ($res->num_rows == 1) {
                            $oldImage = $res->fetch_assoc()["immagine"];
                            $completePathOldImage = $filePath.$oldImage;
                            $query = "UPDATE fornitore SET immagine = ? WHERE IDFornitore = ?";
                            if ($stmt = $conn->prepare($query)) {
                                $stmt->bind_param("ss", $GLOBALS["newFileName"], $idSupplier);
                                if ($stmt->execute()) {
                                    $informationToSendClient["status"] = "OK";
                                    $informationToSendClient["inf"] = "$completeFilePath";
                                    if (strcmp($oldImage, "") != 0) {
                                        unlink("$completePathOldImage");
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
                        $queryError = true;
                    }
                } else {
                    $queryError = true;
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
        $informationToSendClient["inf"] = "File is not an image!";
    }
    if ($queryError) {
        $informationToSendClient["status"] = "ERROR";
        $informationToSendClient["inf"] = "Errore. Riprova più tardi!";
    }
    echo json_encode($informationToSendClient);
?>

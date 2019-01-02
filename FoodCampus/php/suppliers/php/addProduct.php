<?php
    require_once '../../database.php';

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["idCategory"]) && isset($_POST["idSupplier"]) &&
    isset($_POST["productName"]) && isset($_POST["productCost"]) &&
    (!empty($_POST["productName"]) && !strlen(trim($_POST["productName"])) == 0) &&
    $_POST["productCost"] > 0 && $_POST["idCategory"] >= 0 && $_POST["idSupplier"] >= 0) {
        $query="INSERT INTO `prodotto` (`IDCategoria`, `IDFornitore`, `nome`, `costo`) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ssss", $_POST["idCategory"], $_POST["idSupplier"], $_POST["productName"], $_POST["productCost"]);
            if ($stmt->execute()) {
                $query = "SELECT MAX(IDProdotto) as maxId FROM prodotto";
                if ($stmt = $conn->prepare($query)) {
                    if ($stmt->execute()) {
                        $res = $stmt->get_result();
                        if ($res->num_rows == 1) {
                            $idNewProduct = $res->fetch_assoc()["maxId"];
                            $informationToSendClient["status"] = "OK";
                            $informationToSendClient["inf"] = "$idNewProduct";
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
        $informationToSendClient["inf"] = "parametriNonCorretti";
    }
    if ($queryError) {
        $informationToSendClient["status"] = "ERROR";
        $informationToSendClient["inf"] = "errore";
    }
    $conn->close();
    echo json_encode($informationToSendClient);

?>

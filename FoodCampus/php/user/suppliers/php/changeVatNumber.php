<?php
    require_once '../../../database.php';

    function digits_count($n) {
        $count = 0;
            if ($n >= 1){
                ++$count;
            }
            while ($n / 10 >= 1) {
                $n /= 10;
                ++$count;
            }
      return $count;
    }

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["idSupplier"]) && isset($_POST["vatNumber"]) && $_POST["idSupplier"] >= 0) {
        if (is_numeric($_POST["vatNumber"]) && $_POST["vatNumber"] >= 0 &&
                digits_count($_POST["vatNumber"]) == 11) {
            $query = "UPDATE fornitore SET partita_iva = ? WHERE IDFornitore = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("ii", $_POST["vatNumber"], $_POST["idSupplier"]);
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
            $informationToSendClient["inf"] = "partitaIvaNonCorretta";
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

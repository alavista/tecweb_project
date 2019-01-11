<?php
    require_once "../database.php";

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["view"]) && isset($_POST["userId"]) && isset($_POST["fieldId"]) &&
            (!empty($_POST["fieldId"]) && !strlen(trim($_POST["fieldId"])) == 0) && $_POST["userId"] >= 0) {
        $fieldId = $_POST["fieldId"];
        if ($_POST["view"] != "") {
            $query = "UPDATE notifica SET visualizzata = ? WHERE $fieldId = ? AND visualizzata = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("iii", "1", $_POST["userId"], "1");
                if (!$stmt->execute()) {
                    $queryError = true;
                }
            } else {
                $queryError = true;
            }
        }
        if (!$queryError) {
            $notificationTitle = $fieldId == "IDFornitore" ? "Nuovo ordine" : "Ordine partito";
            $query = "SELECT * FROM notifica WHERE $fieldId = ? ORDER BY IDNotifica DESC LIMIT ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("ii", $_POST["userId"], "5");
                if ($stmt->execute()) {
                    $res = $stmt->get_result();
                    if ($res->num_rows > 0) {
                        while($row = $res->fetch_assoc()) {
                            $notification = '
                                        <li>
                                            <a href="#">
                                                <strong>'.$notificationTitle.'</strong><br />
                                                <small><em>'.$row["testo"].'</em></small>
                                            </a>
                                        </li>';
                        }
                    } else {
                        $queryError = true;
                    }
                } else {
                    $queryError = true;
                }
            } else {
                $notification = '<li><a href="#" class="text-bold text-italic">Non hai nessuna notifica!</a></li>';
            }
            $query = "SELECT * FROM notifica WHERE $fieldId = ? AND visualizzata = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("ii", $_POST["userId"], "0");
                if ($stmt->execute()) {
                    $res = $stmt->get_result();
                    $numberNotSeenNotification = $res->num_rows;
                    $informationToSendClient["status"] = "OK";
                    $informationToSendClient["inf"] = "OK";
                    $informationToSendClient = array_push_assoc($informationToSendClient, "notification", "$notification");
                    $informationToSendClient = array_push_assoc($informationToSendClient, "numberNotSeenNotification", "$numberNotSeenNotification");
                } else {
                    $queryError = true;
                }
            } else {
                $queryError = true;
            }
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

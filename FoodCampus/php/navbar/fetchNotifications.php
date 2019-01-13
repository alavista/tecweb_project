<?php
    require_once "../database.php";

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "", "newNotification" => "");
    if (isset($_POST["view"]) && isset($_POST["userId"]) && isset($_POST["fieldId"]) &&
            isset($_POST["numberNotification"]) && (!empty($_POST["fieldId"]) &&
            !strlen(trim($_POST["fieldId"])) == 0) && $_POST["userId"] >= 0) {
        $fieldId = $_POST["fieldId"];
        $userId = $_POST["userId"];
        if ($_POST["view"] != "") {
            $query = "UPDATE notifica SET visualizzata = 1 WHERE $fieldId = ? AND visualizzata = 0";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $userId);
                if (!$stmt->execute()) {
                    $queryError = true;
                }
            } else {
                $queryError = true;
            }
        }
        if (!$queryError) {
            $notificationTitle = $fieldId == "IDFornitore" ? "Nuovo ordine" : "Ordine partito";
            $numberNotification = (int)$_POST["numberNotification"];
            $query = "SELECT * FROM notifica WHERE $fieldId = ? AND visualizzata = 0 ORDER BY IDNotifica DESC";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $userId);
                if ($stmt->execute()) {
                    $res = $stmt->get_result();
                    if ($res->num_rows > $numberNotification) {
                        $numberNewNotifications = $res->num_rows - $numberNotification;
                        $informationToSendClient["newNotification"] = "yes";
                        $informationToSendClient["numberNewNotifications"] = $numberNewNotifications;
                        $informationToSendClient["notificationTitle"] = $notificationTitle;
                        $informationToSendClient["newNotifications"] = array();
                        for ($i = 0; $i < $numberNewNotifications; $i++) {
                            $row = $res->fetch_assoc();
                            $informationToSendClient["newNotifications"]["notificationBody".$i] = $row["testo"];
                        }
                    }
                    $query = "SELECT * FROM notifica WHERE $fieldId = ? ORDER BY IDNotifica DESC LIMIT 5";
                    if ($stmt = $conn->prepare($query)) {
                        $stmt->bind_param("i", $userId);
                        if ($stmt->execute()) {
                            $res = $stmt->get_result();
                            if ($res->num_rows > 0) {
                                $notification = '';
                                while($row = $res->fetch_assoc()) {
                                    if ($fieldId == "IDCliente") {
                                        $notification .= '<span class="dropdown-item"><strong>'.$notificationTitle.'</strong><br/><small><em>'.$row["testo"].'</em></small></span>';
                                    } else {
                                        $notification .= '<a class="dropdown-item"><strong>'.$notificationTitle.'</strong><br/><small><em>'.$row["testo"].'</em></small></a>';
                                    }
                                }
                                $pathForSeeAllNotifications = "/tecweb_project/FoodCampus/php/notifications/notifications.php?id=$userId";
                                $notification .= '<a class="dropdown-item" href="'.$pathForSeeAllNotifications.'"><strong>Tutte le notifiche</strong><br/><small><em>Clicca qui per vedere tutte le notifiche</em></small></a>';
                            } else {
                                $notification = '<span class="dropdown-item text-bold text-italic">Non hai nessuna notifica!</span>';
                            }
                            $query = "SELECT * FROM notifica WHERE $fieldId = ? AND visualizzata = 0";
                            if ($stmt = $conn->prepare($query)) {
                                $stmt->bind_param("i", $userId);
                                if ($stmt->execute()) {
                                    $res = $stmt->get_result();
                                    $numberNotSeenNotification = $res->num_rows;
                                    $informationToSendClient["status"] = "OK";
                                    $informationToSendClient["inf"] = "OK";
                                    $informationToSendClient["notification"] = $notification;
                                    $informationToSendClient["numberNotSeenNotification"] = $numberNotSeenNotification;
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

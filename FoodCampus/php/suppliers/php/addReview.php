<?php
    require_once '../../database.php';
    require_once 'reviewFunction.php';
        $queryError = false;
        $informationToSendClient = array('status' => "", "inf" => "", "newReview" => "", "numberReview" => "", "averageRating" => "");
        if (isset($_POST["idSupplier"]) && isset($_POST["idClient"]) && isset($_POST["title"]) && isset($_POST["comment"]) &&
                isset($_POST["valutation"]) && $_POST["idSupplier"] >= 0 && (!empty($_POST["idClient"]) &&
                $_POST["idClient"]) >= 0 && (!empty($_POST["title"]) &&
                !strlen(trim($_POST["title"])) == 0) && (!empty($_POST["comment"]) &&
                !strlen(trim($_POST["comment"])) == 0) && $_POST["valutation"] >= 0) {
            if (addReview($conn, $_POST["idClient"], $_POST["idSupplier"], $_POST["title"],
                    $_POST["comment"], $_POST["valutation"])) {
                $query = "SELECT * FROM cliente WHERE IDCliente = ?";
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("s", $_POST["idClient"]);
                    if ($stmt->execute()) {
                        $res = $stmt->get_result();
                        if ($res->num_rows == 1) {
                            $client = $res->fetch_assoc();
                            $query = "SELECT COUNT(*) AS numberReview, AVG(valutazione) AS averageRating FROM recensione WHERE IDFornitore = ?";
                            if ($stmt = $conn->prepare($query)) {
                                $stmt->bind_param("s", $_POST["idSupplier"]);
                                if ($stmt->execute()) {
                                    $res = $stmt->get_result();
                                    if ($res->num_rows == 1) {
                                        $averageRatingAndNumberReview = $res->fetch_assoc();
                                        $numberReview = $averageRatingAndNumberReview["numberReview"];
                                        $averageRating = number_format($averageRatingAndNumberReview["averageRating"], 1);
                                        $image = $client["immagine"] != NULL ? $client["immagine"] : "default.png";
                                        $informationToSendClient["status"] = "OK";
                                        $informationToSendClient['newReview'] = "
                                        <div class='media border p-3'>
                                            <img src='../../../res/clients/$image' alt='".$client["nome"]."' id='imageClient' class='mr-3 mt-3 rounded-circle'>
                                            <div class='media-body'>
                                                <input class='rating rating-loading' data-min='0' data-max='5' data-step='1' value='".$_POST["valutation"]."' data-size='md' data-showcaption=false disabled>
                                                <span>".$client["nome"]."</span>
                                                <span class='font-weight-bold'> ".$_POST["title"]."</span>
                                                <p>".$_POST["comment"]."</p>
                                            </div>
                                        </div>";
                                        $informationToSendClient['numberReview'] = "$numberReview recensioni clienti";
                                        $informationToSendClient['averageRating'] = "$averageRating";
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

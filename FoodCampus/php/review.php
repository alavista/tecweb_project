<?php
    if (isset($_POST["idSupplier"]) && isset($_POST["clientEmail"]) && isset($_POST["title"]) && isset($_POST["comment"]) &&
            isset($_POST["valutation"]) && $_POST["idSupplier"] >= 0 && (!empty($_POST["clientEmail"]) &&
            !strlen(trim($_POST["clientEmail"])) == 0) && (!empty($_POST["title"]) &&
            !strlen(trim($_POST["title"])) == 0) && (!empty($_POST["comment"]) &&
            !strlen(trim($_POST["comment"])) == 0) && $_POST["valutation"] >= 0) {
        require_once 'database.php';

        $query_sql = "SELECT * FROM cliente WHERE email = '".$_POST['clientEmail']."'";
        $result = $conn->query($query_sql);
        if ($result !== false && $result->num_rows > 0) {
            $client = $result->fetch_assoc();

            $query_sql="INSERT INTO `recensione` (`IDCliente`, `IDFornitore`, `titolo`, `commento`, `valutazione`) VALUES ('".$client['IDCliente']."', '".$_POST['idSupplier']."', '".$_POST['title']."', '"
                                                                                                                            .$_POST['comment']."', '"
                                                                                                                            .$_POST['valutation']."')";
            if ($conn->query($query_sql) === TRUE) {
                $query_sql = "SELECT COUNT(*) AS numberReview, AVG(valutazione) AS averageRating FROM recensione WHERE IDFornitore = '$_POST[idSupplier]'";
                $result = $conn->query($query_sql);
                if ($result !== false && $result->num_rows > 0) {
                    $averageRatingAndNumberReview = $result->fetch_assoc();
                    $numberReview = $averageRatingAndNumberReview['numberReview'];
                    $averageRating = number_format($averageRatingAndNumberReview['averageRating'], 1);
                    $image = $client["immagine"] != NULL ? $client["immagine"] : "default.png";
                    $arr = array('newReview' => "
                        <div class='media border p-3'>
                            <img src='../res/clients/$image' alt='".$client["nome"]."' id='imageClient' class='mr-3 mt-3 rounded-circle'>
                            <div class='media-body'>
                                <input class='rating rating-loading' data-min='0' data-max='5' data-step='1' value='".$_POST["valutation"]."' data-size='md' data-showcaption=false disabled>
                                <span>".$client["nome"]."</span>
                                <span class='font-weight-bold'> ".$_POST["title"]."</span>
                                <p>".$_POST["comment"]."</p>
                            </div>
                        </div>",
                        'numberReview' => "$numberReview recensioni clienti",
                        'averageRating' => "$averageRating su 5 stelle"
                    );
                    echo json_encode($arr);
                }
            }
            $conn->close();
        }
    }

?>

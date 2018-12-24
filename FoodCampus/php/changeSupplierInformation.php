<?php
    if (isset($_POST["idSupplier"]) && isset($_POST["information"]) && isset($_POST["attribute"]) && (!empty($_POST["information"]) &&
            !strlen(trim($_POST["information"])) == 0) && (!empty($_POST["attribute"]) &&
                    !strlen(trim($_POST["attribute"])) == 0) && $_POST["idSupplier"] >= 0) {
        require_once 'database.php';
        $attribute = $_POST['attribute'];
        $information = $_POST['information'];
        $query_sql = "UPDATE fornitore SET $attribute = '$information' WHERE IDFornitore = '".$_POST['idSupplier']."'";
        if ($conn->query($query_sql) === TRUE) {
            $informationToSendClient = array('inf' => "$information");
            echo json_encode($informationToSendClient);
        }

        $conn->close();
    }
?>

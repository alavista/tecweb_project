<?php
    if (isset($_POST["idSupplier"]) && isset($_POST["newName"]) && (!empty($_POST["newName"]) &&
            !strlen(trim($_POST["newName"])) == 0) && $_POST["idSupplier"] >= 0) {
        require_once 'database.php';
        $name = $_POST['newName'];
        $query_sql = "UPDATE fornitore SET nome = '$name' WHERE IDFornitore = '".$_POST['idSupplier']."'";
        if ($conn->query($query_sql) === TRUE) {
            $informationToSendClient = array('name' => "$name");
            echo json_encode($informationToSendClient);
        }
        $conn->close();
    }
?>

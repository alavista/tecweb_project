<?php
    define("HOST", "localhost"); // E' il server a cui ti vuoi connettere.
    define("USER", "root"); // E' l'utente con cui ti collegherai al DB.
    define("PASSWORD", ""); // Password di accesso al DB.
    define("DATABASE", "foodcampus"); // Nome del database.
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    // Se ti stai connettendo usando il protocollo TCP/IP, invece di usare un socket UNIX, ricordati di aggiungere il parametro corrispondente al numero di porta.

    if ($conn->connect_errno) {
        die("Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error);
    }

    $queryError = false;
    $informationToSendClient = array('status' => "", "inf" => "");
    if (isset($_POST["idProduct"]) && $_POST["idProduct"] > 0) {
        $query="DELETE FROM prodotto WHERE IDProdotto = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $_POST["idProduct"]);
            if ($stmt->execute()) {
                $informationToSendClient["status"] = "OK";
                $informationToSendClient["inf"] = "OK";
            } else {
                $queryError = true;
            }
        } else {
            $queryErrror = true;
        }
    } else {
        $informationToSendClient["status"] = "ERROR";
        $informationToSendClient["inf"] = "Parametri non corretti!";
    }
    if ($queryError) {
        $informationToSendClient["status"] = "ERROR";
        $informationToSendClient["inf"] = "Errore. Riprova più tardi!";
    }
    $conn->close();
    echo json_encode($informationToSendClient);
?>

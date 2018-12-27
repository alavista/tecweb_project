<?php
    define("HOST", "localhost"); // E' il server a cui ti vuoi connettere.
    define("USER", "sec_user"); // E' l'utente con cui ti collegherai al DB.
    define("PASSWORD", "pA36M1xNq3cW6OOY"); // Password di accesso al DB.
    define("DATABASE", "foodcampus"); // Nome del database.
    $conn = $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    // Se ti stai connettendo usando il protocollo TCP/IP, invece di usare un socket UNIX, ricordati di aggiungere il parametro corrispondente al numero di porta.

    if ($conn->connect_errno) {
        die("Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error);
    }
?>

<?php
    $servername="localhost";
    $username ="root";
    $password ="";
    $database = "foodcampus";

    $conn =new mysqli($servername, $username, $password, $database);
    if ($conn->connect_errno) {
        echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }
?>

<?php
    $servername="localhost";
    $username ="root";
    $password ="";
    $database = "foodcampus";

    $GLOBALS["conn"] =new mysqli($servername, $username, $password, $database);
    if ($GLOBALS["conn"]->connect_errno) {
        die("Failed to connect to MySQL: (" . $GLOBALS["conn"]->connect_errno . ") " . $GLOBALS["conn"]->connect_error);
    }
?>

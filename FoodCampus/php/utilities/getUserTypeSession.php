<?php
    require_once "direct_login.php";

    if (!empty($_SESSION["user_type"])) {
        echo $_SESSION["user_type"] == "Fornitore" ? "fornitore" : "cliente";
    } else {
        echo "notDefined";
    }
?>

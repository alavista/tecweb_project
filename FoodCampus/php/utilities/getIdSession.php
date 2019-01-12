<?php
    require_once "direct_login.php";

    if (!empty($_SESSION["user_id"])) {
        echo $_SESSION["user_id"];
    } else {
        echo -1;
    }
?>

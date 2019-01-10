<?php
    require_once "../../../utilities/direct_login.php";

    if (!empty($_SESSION["user_id"])) {
        echo $_SESSION["user_id"];
    } else {
        echo -1;
    }
?>

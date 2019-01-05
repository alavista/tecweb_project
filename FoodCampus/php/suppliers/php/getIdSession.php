<?php
    require_once "../../utilities/direct_login.php";

    if (!empty($_SESSION["user_id"])) {
        echo json_encode($_SESSION["user_id"]);
    } else {
        echo -1;
    }
?>

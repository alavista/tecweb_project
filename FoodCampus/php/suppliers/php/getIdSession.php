<?php
    require_once "../../utilities/direct_login.php";

    echo json_encode($_SESSION["user_id"]);
?>

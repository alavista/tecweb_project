<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once "$root/tecweb_project/FoodCampus/php/utilities/direct_login.php";
    echo "<br/><br/><br/><br/><br/><br/><br/>";
    echo $_SESSION["page"];
    $actual_link = !empty($_SESSION["page"]) ? $_SESSION["page"] : "http://localhost/tecweb_project/FoodCampus/php/home.php";

    if (session_status() == PHP_SESSION_NONE) {
        sec_session_start();
    }
    // Elimina tutti i valori della sessione.
    $_SESSION = array();
    // Recupera i parametri di sessione.
    $params = session_get_cookie_params();
    // Cancella i cookie attuali.
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    // Cancella la sessione.
    session_destroy();
    header("Location: $actual_link");
?>

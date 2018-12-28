<?php
    function create_Session($user_id, $email,  $password, $user_type) {
        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Recupero il parametro 'user-agent' relativo all'utente corrente.

        $user_id = preg_replace("/[^0-9]+/", "", $user_id); // ci proteggiamo da un attacco XSS
        $_SESSION['user_id'] = $user_id;
        $email = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $email); // ci proteggiamo da un attacco XSS
        $_SESSION['email'] = $email;
        $user_type = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $user_type); // ci proteggiamo da un attacco XSS
        $_SESSION['user_type'] = $user_type;
        $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
    }
?>

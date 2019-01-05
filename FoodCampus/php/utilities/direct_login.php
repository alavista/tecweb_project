<?php

require_once "secure_session.php";

$GLOBALS["cookie_user_id"] = "user_id";
$GLOBALS["cookie_user_email"] = "user_email";
$GLOBALS["cookie_user_password"] = "user_password";
$GLOBALS["cookie_user_type"] = "user_type";

// Checks if cookies variables are valid
function checkUserBeforeCookieLogin($conn, $query, $email, $password) {

    if ($stmt = $conn->prepare($query)) {
       $stmt->bind_param('s', $email);
       // Esegui la query ottenuta.
       if (!$stmt->execute()) {
           $GLOBALS["sqlError"] = "Errore durante l'invio dei dati";
           return false;
       }

   } else {
       $GLOBALS["sqlError"] = $conn->error;
       return false;
   }

   $stmt->store_result();
   $stmt->bind_result($user_id, $db_password, $salt, $blocked);
   $stmt->fetch();

   if (isset($blocked) && $blocked !== 0) {
       $GLOBALS["sqlError"] = "Questo utente è stato bloccato, impossibile accedere.";
       return false;
   }

    if ($stmt->num_rows > 0) {
        //$password = hash('sha512', $password.$salt); // codifica la password usando una chiave univoca.
        if ($password == $db_password) {
            return true;
        }
    }

    return false;
}

// Tries direct login with cookies
function isCookieDirectLogin($email, $password, $conn) {

    $GLOBALS["sqlError"] = "";

    $query = "SELECT IDCliente, password, salt, bloccato FROM cliente WHERE email = ?";

    if (checkUserBeforeCookieLogin($conn, $query, $email, $password)) {
        return true;
    } else if (strlen($GLOBALS["sqlError"]) === 0) {

        $query = "SELECT IDFornitore, password, salt, bloccato FROM fornitore WHERE email = ?";

        if (checkUserBeforeCookieLogin($conn, $query, $email, $password)) {
            return true;
        }
    }
    return false;
}

// Checks if user is already logged by cookies or by session.
function isUserLogged($conn) {
    //Try direct login with cookie first
    if (isset($_COOKIE[$GLOBALS["cookie_user_email"]]) && isset($_COOKIE[$GLOBALS["cookie_user_email"]])) {
        if (isCookieDirectLogin($_COOKIE[$GLOBALS["cookie_user_email"]], $_COOKIE[$GLOBALS["cookie_user_password"]], $conn)) {
            return true;
        } else if (strlen($GLOBALS["sqlError"]) !== 0) {
            //Sql error
            return false;
        }
    } else if (login_check($conn)) { //Try direct login with session
        return true;
    }
    return false;
}

?>

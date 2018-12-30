<?php

require_once "../utilities/create_session.php";

$GLOBALS["user_id"] = "";
$GLOBALS["password"] = "";
$GLOBALS["db_password"] = "";

$GLOBALS["sqlError"] = "";
$GLOBALS["sqlWarning"] = "";

function checkbrute($email, $mysqli) {

   // Recupero il timestamp
   $now = time();
   // Vengono analizzati tutti i tentativi di login a partire dagli ultimi 5 minuti
   $valid_attempts = $now - (60 * 5);
   if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE email = ? AND time > '$valid_attempts'")) {
      $stmt->bind_param("s", $email);

      // Eseguo la query creata.
      if (!$stmt->execute()) {
          $GLOBALS["sqlWarning"] = $mysqli->error;
          return false;
      }
      $stmt->store_result();

      // Verifico l'esistenza di più di 5 tentativi di login falliti.
      if($stmt->num_rows > 5) {
          $stmt->close();
         return true;
      } else {
          $stmt->close();
         return false;
      }
   }
}

function do_login($user_id, $email, $password, $db_password, $mysqli, &$emailError) {

    if($db_password == $password) {
        // Verifica che la password memorizzata nel database corrisponda alla password fornita dall'utente.
        // Password corretta!

        create_Session($user_id, $email, $password, $GLOBALS["user_type"]);
        // Login eseguito con successo.
        return true;
    } else {
        // Password incorretta.
        // Registriamo il tentativo fallito nel database.
        $emailError = "Indirizzo email o password non corretti";
        $now = time();
        if (!$mysqli->query("INSERT INTO login_attempts (email, time) VALUES ('$email', '$now')")) {
            $GLOBALS["sqlWarning"] = $mysqli->error;
            return false;
        }
    }

    return false;
}

function isUserValid($mysqli, $email, $password, $query) {
    $sentEmail = $email;
    $sentPassword = $password;

    // Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('s', $sentEmail); // esegue il bind del parametro '$email'.
        // esegue la query appena creata.
        if (!$stmt->execute()) {
            $GLOBALS["sqlError"] = $mysqli->error;
            return false;
        }
        $stmt->store_result();
        $stmt->bind_result($user_id, $email, $db_password, $salt, $blocked); // recupera il risultato della query e lo memorizza nelle relative variabili.
        $stmt->fetch();

        $GLOBALS["password"] = hash('sha512', $password.$salt); // codifica la password usando una chiave univoca.
        $GLOBALS["db_password"] = $db_password;
        $GLOBALS["user_id"] = $user_id;

		if($stmt->num_rows == 1) {

            if ($blocked !== 0) {
                $GLOBALS["sqlError"] = "Questo utente è stato bloccato, impossibile accedere.";
                return false;
            }

			return true;

        } else {
            $GLOBALS["sqlError"] = $mysqli->error;
            return false;
        }
    } else {
        $GLOBALS["sqlError"] = $mysqli->error;
        return false;
    }

    return false;
}

function login($mysqli, $email, $password, &$emailError) {
    $query = "SELECT IDCliente, email, password, salt, bloccato FROM cliente WHERE email = ? LIMIT 1";

    if (!isUserValid($mysqli, $email, $password, $query)) {

        if (strlen($GLOBALS["sqlError"]) === 0) {
            $query = "SELECT IDFornitore, email, password, salt, bloccato FROM fornitore WHERE email = ? LIMIT 1";

            if (!isUserValid($mysqli, $email, $password, $query)) {

                if (strlen($GLOBALS["sqlError"]) === 0) {
                    $emailError = "Nessun utente registrato con questo indirizzo email";
                }

                return false;
            } else {
                $GLOBALS["user_type"] = "Fornitore";
            }

        } else {
            return false;
        }
    } else {
        $GLOBALS["user_type"] = "Cliente";
    }

    if (checkbrute($email, $mysqli)) {
        $emailError = "Questo utente è stato bloccato temporaneamente a causa dei troppi tentativi di accesso.<br/>Riprovare pi&ugrave; tardi.";
        return false;
    }

    return do_login($GLOBALS["user_id"], $email, $GLOBALS["password"], $GLOBALS["db_password"], $mysqli, $emailError);
}

?>

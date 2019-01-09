<?php

require_once "../utilities/create_session.php";
require_once "../suppliers/php/reviewFunction.php";

$GLOBALS["user_id"] = "";
$GLOBALS["password"] = "";
$GLOBALS["db_password"] = "";

$GLOBALS["sqlError"] = "";
$GLOBALS["sqlWarning"] = "";

function isSessionForReview() {
	return !empty($_SESSION["validReview"]) && !empty($_SESSION["idSupplierForReview"]) &&
			!empty($_SESSION["titleReview"]) && !empty($_SESSION["commentReview"]) &&
			!empty($_SESSION["valutationReview"]) ? true : false;
}

function unsetSessionForReview() {
	unset($_SESSION['validReview']);
	unset($_SESSION['idSupplierForReview']);
	unset($_SESSION['titleReview']);
	unset($_SESSION['commentReview']);
	unset($_SESSION['valutationReview']);
}

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
                $GLOBALS["user_banned"] = true;
                return false;
            }
			$GLOBALS["user_banned"] = false;
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

        if ($GLOBALS["sqlError"] === "") {
            $query = "SELECT IDFornitore, email, password, salt, bloccato FROM fornitore WHERE email = ? LIMIT 1";

            if (!isUserValid($mysqli, $email, $password, $query)) {

                if ($GLOBALS["user_banned"] === false && $GLOBALS["sqlError"] === "") {
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
    if (isSessionForReview()) {
        if ($GLOBALS["user_type"] == "Cliente" && !(addReview($mysqli, $GLOBALS["user_id"], $_SESSION["idSupplierForReview"],
                $_SESSION["titleReview"], $_SESSION["commentReview"],
                $_SESSION["valutationReview"]))) {
            $emailError = "C'è stato un errore con l'inserimento della nuova recensione. Riprova più tardi!";
            $_SESSION["validReview"] = "yes";
            return false;
        } else if ($GLOBALS["user_type"] == "Fornitore") {
            $emailError = "Utente cliente non trovato!!";
            $_SESSION["validReview"] = "yes";
            return false;
        }
    }
    return do_login($GLOBALS["user_id"], $email, $GLOBALS["password"], $GLOBALS["db_password"], $mysqli, $emailError);
}

?>

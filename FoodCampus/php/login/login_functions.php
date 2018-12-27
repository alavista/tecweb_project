<?php

require_once "../utilities/secure_session.php";

function checkbrute($user_id, $mysqli) {
   // Recupero il timestamp
   $now = time();
   // Vengono analizzati tutti i tentativi di login a partire dalle ultime due ore.
   $valid_attempts = $now - (2 * 60 * 60);
   if ($stmt = $mysqli->prepare("SELECT time FROM clients_login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
      $stmt->bind_param('i', $user_id);
      // Eseguo la query creata.
      $stmt->execute();
      $stmt->store_result();
      // Verifico l'esistenza di più di 5 tentativi di login falliti.
      if($stmt->num_rows > 5) {
         return true;
      } else {
         return false;
      }
   }
}

function do_login($user_id, $email, $password, $db_password, $mysqli) {
	// se l'utente esiste
	// verifichiamo che non sia disabilitato in seguito all'esecuzione di troppi tentativi di accesso errati.
	if(checkbrute($user_id, $mysqli) == true) {
		// Account disabilitato
		// Invia un e-mail all'utente avvisandolo che il suo account è stato disabilitato.
		return -2;
	} else {

		if($db_password == $password) {
			// Verifica che la password memorizzata nel database corrisponda alla password fornita dall'utente.
			// Password corretta!
			$user_browser = $_SERVER['HTTP_USER_AGENT']; // Recupero il parametro 'user-agent' relativo all'utente corrente.

			$user_id = preg_replace("/[^0-9]+/", "", $user_id); // ci proteggiamo da un attacco XSS
			$_SESSION['user_id'] = $user_id;
			$email = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $email); // ci proteggiamo da un attacco XSS
			$_SESSION['email'] = $email;
            $user_type = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $GLOBALS["user_type"]); // ci proteggiamo da un attacco XSS
			$_SESSION['user_type'] = $user_type;
			$_SESSION['login_string'] = hash('sha512', $password.$user_browser);

			// Login eseguito con successo.
			return 1;
		} else {
			// Password incorretta.
			// Registriamo il tentativo fallito nel database.
			$now = time();
			$mysqli->query("INSERT INTO login_attempts (email, time) VALUES ('$email', '$now')");

			return -1;
		}
	}
}

function login($email, $password, $mysqli) {
    $sentEmail = $email;
    $sentPassword = $password;
    // Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
    if ($stmt = $mysqli->prepare("SELECT IDCliente, email, password, salt FROM cliente WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $sentEmail); // esegue il bind del parametro '$email'.
        $stmt->execute(); // esegue la query appena creata.
        $stmt->store_result();
        $stmt->bind_result($user_id, $email, $db_password, $salt); // recupera il risultato della query e lo memorizza nelle relative variabili.
        $stmt->fetch();
        $password = hash('sha512', $password.$salt); // codifica la password usando una chiave univoca.

		if($stmt->num_rows == 1) {
			$GLOBALS["user_type"] = "Cliente";
			return do_login($user_id, $email, $password, $db_password, $mysqli);

		} else if ($stmt = $mysqli->prepare("SELECT IDFornitore, email, password, salt FROM fornitore WHERE email = ? LIMIT 1")) {
				$stmt->bind_param('s', $sentEmail); // esegue il bind del parametro '$email'.
				$stmt->execute(); // esegue la query appena creata.
				$stmt->store_result();
				$stmt->bind_result($user_id, $email, $db_password, $salt); // recupera il risultato della query e lo memorizza nelle relative variabili.
				$stmt->fetch();
				$password = hash('sha512', $sentPassword.$salt); // codifica la password usando una chiave univoca.

				if($stmt->num_rows == 1) {
					$GLOBALS["user_type"] = "Fornitore";
					return do_login($user_id, $email, $password, $db_password, $mysqli);

				} else {
					// L'utente inserito non esiste.
					return 0;
				}
			}
    }
}

?>
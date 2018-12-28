<?php
function sec_session_start() {
    $session_name = 'sec_session_id'; // Imposta un nome di sessione
    $secure = false; // Imposta il parametro a true se vuoi usare il protocollo 'https'.
    $httponly = true; // Questo impedirà ad un javascript di essere in grado di accedere all'id di sessione.
    ini_set('session.use_only_cookies', 1); // Forza la sessione ad utilizzare solo i cookie.
    $cookieParams = session_get_cookie_params(); // Legge i parametri correnti relativi ai cookie.
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    session_name($session_name); // Imposta il nome di sessione con quello prescelto all'inizio della funzione.
    session_start(); // Avvia la sessione php.
    session_regenerate_id(); // Rigenera la sessione e cancella quella creata in precedenza.
}

function login_check($mysqli) {

   // Verifica che tutte le variabili di sessione siano impostate correttamente
   if(isset($_SESSION['user_id'], $_SESSION['email'], $_SESSION['login_string'], $_SESSION['user_type'])) {
     $user_id = $_SESSION['user_id'];
     $login_string = $_SESSION['login_string'];
     $email = $_SESSION['email'];
     $user_browser = $_SERVER['HTTP_USER_AGENT']; // reperisce la stringa 'user-agent' dell'utente.

	 if ($_SESSION["user_type"] === "Cliente") {
		 $query = "SELECT password FROM cliente WHERE IDCliente = ? LIMIT 1";
	 } else {
		 $query = "SELECT password FROM fornitore WHERE IDFornitore = ? LIMIT 1";
	 }

     if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('i', $user_id); // esegue il bind del parametro '$user_id'.
        if (!$stmt->execute()) { // Esegue la query creata.
            $GLOBALS["sqlError"] = $mysqli->error;
            return false;
        }
        $stmt->store_result();

        if($stmt->num_rows == 1) { // se l'utente esiste
           $stmt->bind_result($password); // recupera le variabili dal risultato ottenuto.
           $stmt->fetch();
           $login_check = hash('sha512', $password.$user_browser);
           if($login_check == $login_string) {
              // Login eseguito!!!!
              return true;
           } else {
              //  Login non eseguito
              return false;
           }
        } else {
            // Login non eseguito
            return false;
        }
     } else {
        // Login non eseguito
        $GLOBALS["sqlError"] = $mysqli->error;
        return false;
     }
   } else {
     // Login non eseguito
     return false;
   }
}
?>

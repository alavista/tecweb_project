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
       $GLOBALS["user_banned"] = true;
       return false;
   }
   $GLOBALS["user_banned"] = false;

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
    } else if ($GLOBALS["user_banned"] === false && $GLOBALS["sqlError"] === "") {

        $query = "SELECT IDFornitore, password, salt, bloccato FROM fornitore WHERE email = ?";

        if (checkUserBeforeCookieLogin($conn, $query, $email, $password)) {
            return true;
        }
    }
    return false;
}

//reefresh cart in session and database
function refreshCart($conn) {
  $stmt = $conn->prepare("SELECT * FROM prodotto_in_carrello WHERE IDCliente = ?");
  $stmt->bind_param("i", $user);
  $user = $_SESSION['user_id'];
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    if(!isset($_SESSION["cart_filled"]) || !isset($_SESSION["cart"])) {
      $_SESSION["cart_filled"] = "true";
      $_SESSION["cart"] = array();
      $_SESSION["cart"][$row["IDProdotto"]] = $row["quantita"];
    } else {
      if(!isset($_SESSION["cart"][$row["IDProdotto"]])) {
        $_SESSION["cart"][$row["IDProdotto"]] = $row["quantita"];
      } else {
        $_SESSION["cart"][$row["IDProdotto"]] += $row["quantita"];
      }
    }
  }

  $stmt = $conn->prepare("INSERT INTO prodotto_in_carrello (IDCliente, IDProdotto, quantita) VALUES(?, ? ,?)");
  $stmt->bind_param("iii", $user, $product, $quantity);
  $conn2 = new mysqli("localhost", "root", "", "foodcampus");
  if ($conn2->connect_errno) {
    die("Failed to connect to MySQL: (" . $conn2->connect_errno . ") " . $conn2->connect_error);
  }
  $stmt2 = $conn2->prepare("DELETE FROM prodotto_in_carrello WHERE IDCliente = ? && IDProdotto = ?");
  $stmt2->bind_param("ii", $user, $product);
  if(isset($_SESSION["cart_filled"]) && isset($_SESSION["cart"])) {
    foreach($_SESSION["cart"] as $prod => $quant) {
      $product = $prod;
      $quantity = $quant;
      $stmt2->execute();
      $stmt->execute();
    }
  }
}

function getIDClienteByEmail($conn, $email) {
  $stmt = $conn->prepare("SELECT IDCliente FROM cliente WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  return $row["IDCliente"];
}

// Checks if user is already logged by cookies or by session.
function isUserLogged($conn) {
    //Try direct login with cookie first
    if (isset($_COOKIE[$GLOBALS["cookie_user_email"]]) && isset($_COOKIE[$GLOBALS["cookie_user_email"]])) {
        if (isCookieDirectLogin($_COOKIE[$GLOBALS["cookie_user_email"]], $_COOKIE[$GLOBALS["cookie_user_password"]], $conn)) {
            if(!isset($_SESSION['cart_filled'])) {
              $_SESSION['user_id'] = getIDClienteByEmail($conn, $_COOKIE[$GLOBALS["cookie_user_email"]]);
              refreshCart($conn);
            }
            return true;
        } else if ($GLOBALS["sqlError"] !== "") {
            //Sql error
            return false;
        }
    } else if (login_check($conn)) { //Try direct login with session
        return true;
    }
    return false;
}

function redirectToPageNotFound($conn) {
    header("Location: /tecweb_project/FoodCampus/php/pageNotFound.html");
    $conn->close();
    exit();
}

?>

<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/tecweb_project/FoodCampus/php/database.php";
require_once "$root/tecweb_project/FoodCampus/php/utilities/direct_login.php";

$GLOBALS["response"] = array("status" => "", "data" => "", "isSupplier" => "false");

function getSuppliers($conn, $string) {

    if (!($stmt = $conn->prepare("SELECT f.nome as fnome, f.IDFornitore as fid
                                    FROM fornitore as f
                                    WHERE f.bloccato = 0 AND f.abilitato = 1"))) {

        $GLOBALS["response"]["status"] = "error";
        $GLOBALS["response"]["data"] = $conn->error;

        return ($GLOBALS["response"]);
    }

    if (!$stmt->execute()) {
        $GLOBALS["response"]["status"] = "error";
        $GLOBALS["response"]["data"] = $conn->error;
        return ($GLOBALS["response"]);
    }

    if (!($result = $stmt->get_result())) {
        $GLOBALS["response"]["status"] = "error";
        $GLOBALS["response"]["data"] = $conn->error;
        return ($GLOBALS["response"]);
    }

    $output = array();
    if ($string !== "") {
        $string = strtolower($string);
        $len = strlen($string);

        while ($row = $result->fetch_assoc()) {
            // lookup all hints from array if $q is different from ""
            if (stristr($string, substr($row["fnome"], 0, $len))) {
                $output[] = $row;
            }
        }
    }

    $stmt->close();

    $GLOBALS["response"]["status"] = "ok";
    $GLOBALS["response"]["data"] = $output;
    $GLOBALS["response"]["isSupplier"] = false;

    return $GLOBALS["response"];
}

function getProducts($conn, $string) {

    if (!($stmt = $conn->prepare("SELECT p.IDProdotto as IDProdotto, p.nome as pnome, p.costo as prezzo, p.vegano as vegano, p.celiaco as celiaco, f.nome as fnome
                                    FROM prodotto as p, fornitore as f
                                    WHERE p.IDFornitore = f.IDFornitore
                                    AND f.bloccato = 0 AND f.abilitato = 1
                                    GROUP BY f.IDFornitore, p.IDProdotto"))) {

        $GLOBALS["response"]["status"] = "error";
        $GLOBALS["response"]["data"] = $conn->error;

        return ($GLOBALS["response"]);
    }

    if (!$stmt->execute()) {
        $GLOBALS["response"]["status"] = "error";
        $GLOBALS["response"]["data"] = $conn->error;
        return ($GLOBALS["response"]);
    }

    if (!($result = $stmt->get_result())) {
        $GLOBALS["response"]["status"] = "error";
        $GLOBALS["response"]["data"] = $conn->error;
        return ($GLOBALS["response"]);
    }

    $output = array();
    if ($string !== "") {
        $string = strtolower($string);
        $len = strlen($string);

        while ($row = $result->fetch_assoc()) {
            // lookup all hints from array if $q is different from ""
            if (stristr($string, substr($row["pnome"], 0, $len))) {
                $output[] = $row;
            }
        }
    }

    $stmt->close();

    $isSupplier = false;
    if (isset($_COOKIE["user_email"])) {
        $query="SELECT * FROM fornitore WHERE email = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $_COOKIE["user_email"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                $isSupplier = ($stmt->num_rows > 0) ? true : false;
            }
        }
    } else if ((!empty($_SESSION["user_type"])) && $_SESSION["user_type"] == "Fornitore") {
        $isSupplier = true;
    }

    $GLOBALS["response"]["status"] = "ok";
    $GLOBALS["response"]["data"] = $output;
    $GLOBALS["response"]["isSupplier"] = $isSupplier;

    return $GLOBALS["response"];
}

if (isset($_POST["request"])) {

    if (!empty($_POST["request"]) && isset($_POST["string"])) {
        switch ($_POST["request"]) {
            case "products":
                print json_encode(getProducts($conn, $_POST["string"]));
            break;

            case "suppliers":
                print json_encode(getSuppliers($conn, $_POST["string"]));
            break;
        }
    } else {
        $GLOBALS["response"]["status"] = "error";
        $GLOBALS["response"]["data"] = "Error on request";
        print json_encode($GLOBALS["response"]);
    }
}
?>

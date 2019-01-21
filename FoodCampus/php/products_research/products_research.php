<?php
require_once "../database.php";
require_once "../utilities/direct_login.php";

$GLOBALS["response"] = array("status" => "", "data" => "", "isSupplier" => "false");

function getCategories($conn) {
    if (!($stmt = $conn->prepare("SELECT nome FROM categoria ORDER BY IDCategoria"))) {
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

	while ($row = $result->fetch_assoc()) {
		$output[] = $row;
	}

	$stmt->close();

    $GLOBALS["response"]["status"] = "ok";
    $GLOBALS["response"]["data"] = $output;

    return $GLOBALS["response"];
}

function getProductsSorting($sortQuery) {

    switch ($sortQuery) {

        case "Nome Prodotto (A-Z)":
            return "ORDER BY p.nome ASC";
        break;

        case "Nome Prodotto (Z-A)":
            return "ORDER BY p.nome DESC";
        break;

        case "Nome Fornitore (A-Z)":
            return "ORDER BY f.nome ASC";
        break;

        case "Nome Fornitore (Z-A)":
            return "ORDER BY f.nome DESC";
        break;

        case "Prezzo (crescente)":
            return "ORDER BY p.costo ASC";
        break;

        case "Prezzo (decrescente)":
            return "ORDER BY p.costo DESC";
        break;

        case "Voto Fornitore (crescente)":
            return "ORDER BY valutazione_media ASC";
        break;

        case "Voto Fornitore (decrescente)":
            return "ORDER BY valutazione_media DESC";
        break;

        default:
            return "ORDER BY valutazione_media DESC";

    }
}

function getProducts($conn, $category, $vegan, $celiac, $sorting) {

    $sortingQuery = getProductsSorting($sorting);
    $veganQuery = ($vegan === "true") ? "AND p.vegano = 1" : "";
    $celiacQuery = ($celiac === "true") ? "AND p.celiaco = 1" : "";

    $query = "SELECT p.IDProdotto as pid, p.nome as pnome, p.costo, p.vegano as vegano, p.celiaco as celiaco, c.nome as cnome, f.IDFornitore as IDFornitore, f.nome as fnome, AVG(r.valutazione) as valutazione_media, COUNT(r.IDRecensione) as nrec
                                    FROM categoria as c, prodotto as p, fornitore as f
                                    LEFT OUTER JOIN recensione r ON (r.IDFornitore = f.IDFornitore)
                                    WHERE c.IDCategoria = p.IDCategoria AND p.IDFornitore = f.IDFornitore
                                    AND c.nome = '$category'
                                    AND f.bloccato = 0 AND f.abilitato = 1
                                    $veganQuery
                                    $celiacQuery
                                    GROUP BY f.IDFornitore, p.IDProdotto
                                    $sortingQuery";

    if (!($stmt = $conn->prepare($query))) {

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

	while ($row = $result->fetch_assoc()) {
		$output[] = $row;
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


if (isset($_POST["request"]) && !empty($_POST["request"])) {
    switch ($_POST["request"]) {
        case "categories":
            print json_encode(getCategories($conn));
        break;

        case "products":
            if (isset($_POST["category"]) && !empty($_POST["category"])) {
                if (!isset($_POST["vegan"]) || ($_POST["vegan"] !== "true" && $_POST["vegan"] !== "false")) {
                    $GLOBALS["response"]["status"] = "error";
                    $GLOBALS["response"]["data"] = "Error on vegan value";
                    print json_encode($GLOBALS["response"]);
                } else if (!isset($_POST["celiac"]) || ($_POST["celiac"] !== "true" && $_POST["celiac"] !== "false")) {
                    $GLOBALS["response"]["status"] = "error";
                    $GLOBALS["response"]["data"] = "Error on celiac value";
                    print json_encode($GLOBALS["response"]);
                } else {
                    print json_encode(getProducts($conn, $_POST["category"], $_POST["vegan"], $_POST["celiac"], $_POST["sort"]));
                }
            } else {
                $GLOBALS["response"]["status"] = "error";
                $GLOBALS["response"]["data"] = "Error on product request";
                print json_encode($GLOBALS["response"]);
            }
        break;
    }
}
?>

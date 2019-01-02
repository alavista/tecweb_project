<?php
require_once "../database.php";
require_once "../utilities/direct_login.php";

$GLOBALS["response"] = array("status" => "", "data" => "");

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

function getProducts($conn, $category) {
    if (!($stmt = $conn->prepare("SELECT p.nome as pnome, p.costo, c.nome as cnome, f.nome as fnome, AVG(r.valutazione) as valutazione_media, COUNT(r.IDRecensione) as nrec
                                    FROM categoria as c, prodotto as p, fornitore as f
                                    LEFT OUTER JOIN recensione r ON (r.IDFornitore = f.IDFornitore)
                                    WHERE c.IDCategoria = p.IDCategoria AND p.IDFornitore = f.IDFornitore
                                    AND c.nome = '$category'
                                    GROUP BY f.IDFornitore, p.IDProdotto
                                    ORDER BY valutazione_media  DESC"))) {

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


if (isset($_POST["reqest"]) && !empty($_POST["reqest"])) {
    switch ($_POST["reqest"]) {
        case "categories":
            print json_encode(getCategories($conn));
        break;

        case "products":
            if (isset($_POST["value"]) && !empty($_POST["value"])) {
                print json_encode(getProducts($conn, $_POST["value"]));
            } else {
                $GLOBALS["response"]["status"] = "error";
                $GLOBALS["response"]["data"] = "Error on product request";
                print json_encode($GLOBALS["response"]);
            }
        break;
    }
}
?>

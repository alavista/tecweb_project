<?php
require_once "../database.php";
require_once "../utilities/direct_login.php";

$GLOBALS["response"] = array("status" => "", "data" => "");

function getCategories($conn) {
    if (!($stmt = $conn->prepare("SELECT nome FROM categoria ORDER BY IDCategoria"))) {
        return $smt->error;
    }

    if (!$stmt->execute()) {
        return $smt->error;
    }

    if (!($result = $stmt->get_result())) {
        return $smt->error;
    }

    $output = array();

	while ($row = $result->fetch_assoc()) {
		$output[] = $row;
	}

	$stmt->close();

    return $output;
}

function getProducts($conn) {
    if (!($stmt = $conn->prepare("SELECT p.nome, p.costo, c.nome, f.nome
                                    FROM categoria as c, prodotto as p, fornitore as f
                                    WHERE c.IDCategoria = p.IDCategoria AND p.IDFornitore = f.IDFornitore
                                    GROUP BY f.IDFornitore
                                    ORDER BY f.nome"))) {

        $GLOBALS["response"]["status"] = "error";
        $GLOBALS["response"]["data"] = $smt->error;

        return ($GLOBALS["response"]);
    }

    if (!$stmt->execute()) {
        $GLOBALS["response"]["status"] = "error";
        $GLOBALS["response"]["data"] = $smt->error;
        return ($GLOBALS["response"]);
    }

    if (!($result = $stmt->get_result())) {
        $GLOBALS["response"]["status"] = "error";
        $GLOBALS["response"]["data"] = $smt->error;
        return ($GLOBALS["response"]);
    }

    $output = array();

	while ($row = $result->fetch_assoc()) {
		$output[] = $row;
	}

	$stmt->close();

    $GLOBALS["response"]["status"] = "ok";
    $GLOBALS["response"]["data"] = $output;
    return $output;
}


if (isset($_POST["reqest"]) && !empty($_POST["reqest"])) {
    switch ($_POST["reqest"]) {
        case "categories":
            print json_encode(getCategories($conn));
        break;

        case "products":
            if (isset($_POST["value"]) && !empty($_POST["value"])) {
                getProducts($conn, $_POST["value"]);
                print json_encode($GLOBALS["response"]);
            } else {
                $GLOBALS["response"]["status"] = "error";
                $GLOBALS["response"]["data"] = "Error on product request";
                print json_encode($GLOBALS["response"]);
            }
        break;
    }
}
?>

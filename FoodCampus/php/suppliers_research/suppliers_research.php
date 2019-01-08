<?php
require_once "../database.php";

$GLOBALS["response"] = array("status" => "", "data" => "");

function getSorting($sortQuery) {

    switch ($sortQuery) {
        case "Nome Fornitore (A-Z)":
            return "ORDER BY f.nome ASC";
        break;

        case "Nome Fornitore (Z-A)":
            return "ORDER BY f.nome DESC";
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

function getSuppliers($conn, $category, $vegan, $celiac, $sorting) {

    $sortingQuery = getSorting($sorting);
    $veganQuery = ($vegan === "true") ? "HAVING SUM(p.vegano > 0)" : "";
    $celiacQuery = ($celiac === "true") ? ($vegan === "true") ? " AND SUM(p.celiaco > 0)" : "HAVING SUM(p.celiaco > 0)" : "";

    $categoryQuery = "";
    $noCategoryQuery = "";
    if ($category !== "none") {
        if (count($category) > 0) {
            $categoryQuery = ($celiac === "true" || $vegan === "true") ? "AND " : "HAVING ";
            $categoryQuery .= "(";
            foreach ($category as &$value) {
                $categoryQuery .= "SUM(CASE WHEN c.nome='".$value."' then 1 else 0 end) OR ";
            }
            $categoryQuery = substr($categoryQuery, 0, -4);
            $categoryQuery .= ")";
        }
    } else {
        $noCategoryQuery = "AND c.nome in ('')";
    }

    $query = "SELECT f.IDFornitore, f.nome as fnome, f.immagine as fimmagine, AVG(r.valutazione) as valutazione_media, COUNT(DISTINCT r.IDRecensione) as nrec
                                    FROM categoria as c, prodotto as p, fornitore as f
                                    LEFT OUTER JOIN recensione r ON (r.IDFornitore = f.IDFornitore)
                                    WHERE c.IDCategoria = p.IDCategoria AND p.IDFornitore = f.IDFornitore
                                    $noCategoryQuery
                                    GROUP BY f.IDFornitore
                                    $veganQuery
                                    $celiacQuery
                                    $categoryQuery
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

    if (isset($_COOKIE["user_email"])) {
        $query="SELECT * FROM fornitore WHERE email = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $_COOKIE["user_email"]);
            if ($stmt->execute()) {
                $stmt->store_result();
            }
        }
    }

    $GLOBALS["response"]["status"] = "ok";
    $GLOBALS["response"]["data"] = $output;

    return $GLOBALS["response"];
}

if (isset($_POST["request"]) && !empty($_POST["request"])) {
	switch ($_POST["request"]) {
        case "suppliers":
			if (!isset($_POST["category"])) {
				$GLOBALS["response"]["status"] = "error";
				$GLOBALS["response"]["data"] = "Error on category value";
				print json_encode($GLOBALS["response"]);
			} else if (!isset($_POST["vegan"]) || ($_POST["vegan"] !== "true" && $_POST["vegan"] !== "false")) {
				$GLOBALS["response"]["status"] = "error";
				$GLOBALS["response"]["data"] = "Error on vegan value";
				print json_encode($GLOBALS["response"]);
	        } else if (!isset($_POST["celiac"]) || ($_POST["celiac"] !== "true" && $_POST["celiac"] !== "false")) {
	            $GLOBALS["response"]["status"] = "error";
	            $GLOBALS["response"]["data"] = "Error on celiac value";
				print json_encode($GLOBALS["response"]);
	        } else {
	            print json_encode(getSuppliers($conn, $_POST["category"], $_POST["vegan"], $_POST["celiac"], $_POST["sort"]));
	        }
    	break;
    }
}

?>

<?php

	$PRIMARY_KEYS = array(
        "categoria" => "IDCategoria",
        "cliente" => "IDCliente",
        "fornitore" => "IDFornitore",
        "notifica" => "IDNotifica",
        "ordine" => "IDOrdine",
        "prodotto" => "IDProdotto",
        "recensione" => "IDRecensione",
        "prodotto_in_ordine" => "IDProdottoInOrdine"
    );

    $DB_TABLES = array("Clienti"=>"cliente", "Fornitori"=>"fornitore", "Categorie"=>"categoria", "Prodotti"=>"prodotto", "Ordini"=>"ordine", "Recensioni"=>"recensione", "Notifiche"=>"notifica", "Prodotti_in_ordine"=>"prodotto_in_ordine");

    $DB_NUMERIC_TYPES = array("int", "decimal", "bit", "float", "tinyint");

    $DB_FLOAT_TYPES = array("decimal", "float");

    function getQuerySearchByID($table, $id) {
    	switch($table) {
			case "categoria":
				$sql = "SELECT * FROM categoria WHERE IDCategoria = ".$id;
				break;
        	case "prodotto":
        		$sql = "SELECT * FROM prodotto WHERE IDProdotto = ".$id;
        		break;
        	case "cliente":
				$sql = "SELECT * FROM cliente WHERE IDCliente = ".$id;
				break;
        	case "fornitore":
        		$sql = "SELECT * FROM fornitore WHERE IDFornitore = ".$id;
        		break;
        	case "notifica":
				$sql = "SELECT * FROM notifica WHERE IDNotifica = ".$id;
				break;
        	case "ordine":
        		$sql = "SELECT * FROM ordine WHERE IDOrdine = ".$id;
        		break;
        	case "recensione":
				$sql = "SELECT * FROM recensione WHERE IDRecensione = ".$id;
				break;
            case "prodotto_in_ordine":
                $sql = "SELECT * FROM prodotto_in_ordine WHERE IDProdottoInOrdine = ".$id;
                break;
		}
		return $sql;
    }

    function getQuerySearch($table) {
    	switch($table) {
			case "categoria":
				$sql = "SELECT * FROM categoria";
				break;
        	case "prodotto":
        		$sql = "SELECT * FROM prodotto";
        		break;
        	case "cliente":
				$sql = "SELECT * FROM cliente";
				break;
        	case "fornitore":
        		$sql = "SELECT * FROM fornitore";
        		break;
        	case "notifica":
				$sql = "SELECT * FROM notifica";
				break;
        	case "ordine":
        		$sql = "SELECT * FROM ordine";
        		break;
        	case "recensione":
				$sql = "SELECT * FROM recensione";
				break;
            case "prodotto_in_ordine":
                $sql = "SELECT * FROM prodotto_in_ordine";
                break;
		}
		return $sql;
    }

    function getQuerySearchExtern($table) {
    	switch($table) {
			case "categoria":
				$sql = "SELECT IDCategoria, nome FROM categoria";
				break;
        	case "prodotto":
        		$sql = "SELECT IDProdotto, nome FROM prodotto";
        		break;
        	case "cliente":
				$sql = "SELECT IDCliente, nome, cognome, email FROM cliente";
				break;
        	case "fornitore":
        		$sql = "SELECT IDFornitore, nome FROM fornitore";
        		break;
        	case "notifica":
				$sql = "SELECT IDNotifica, testo, visualizzata FROM notifica";
				break;
        	case "ordine":
        		$sql = "SELECT IDOrdine FROM ordine";
        		break;
        	case "recensione":
				$sql = "SELECT IDRecensione, titolo, valutazione FROM recensione";
				break;
            case "prodotto_in_ordine":
                $sql = "SELECT IDProdottoInOrdine FROM prodotto_in_ordine";
                break;
		}
		return $sql;
    }

	function getQuerySearchExternByID($table, $id) {
    	switch($table) {
			case "categoria":
				$sql = "SELECT IDCategoria, nome FROM categoria WHERE IDCategoria = ".$id;
				break;
        	case "prodotto":
        		$sql = "SELECT IDProdotto, nome FROM prodotto WHERE IDProdotto = ".$id;
        		break;
        	case "cliente":
				$sql = "SELECT IDCliente, nome, cognome, email FROM cliente WHERE IDCliente = ".$id;
				break;
        	case "fornitore":
        		$sql = "SELECT IDFornitore, nome FROM fornitore WHERE IDFornitore = ".$id;
        		break;
        	case "notifica":
				$sql = "SELECT IDNotifica, testo, visualizzata FROM notifica WHERE IDNotifica = ".$id;
				break;
        	case "ordine":
        		$sql = "SELECT IDOrdine FROM ordine WHERE IDOrdine = ".$id;
        		break;
        	case "recensione":
				$sql = "SELECT IDRecensione, titolo, valutazione FROM recensione WHERE IDRecensione = ".$id;
				break;
		}
		return $sql;
    }

?>
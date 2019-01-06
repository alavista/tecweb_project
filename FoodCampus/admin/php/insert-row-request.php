<?php
    require_once("../../php/database.php");
    require_once("db-info.php");

    if(isset($_POST["table"])) {
    	$table = $_POST["table"];
    	$sql = "INSERT INTO ".$table."(";
    	$first = true;
    	foreach($_POST as $key => $value) {
    		if($first == true) {
    			$first = false;
    		} else {
    			$sql = $sql.$key.",";
    		} 
    	}
    	$first = true;
    	$sql = substr($sql, 0, -1).") VALUES (";
    	foreach($_POST as $value) {
    		if($first == true) {
    			$first = false;
    		} else {
	    		$plus = 0;
	    		if(is_numeric($value)) {
					$sql = $sql.$value.",";
					$plus = -1;
	    		} else {
		    		$sql = $sql."'".$value."',"; 
		    		$plus = -1;
		    	}
		    }
    	}
    	$sql = substr($sql, 0, $plus).");";
    	$result = $GLOBALS["conn"]->query($sql);
    	if($result) {
    		echo "<div class='alert alert-success' role='alert'>Inserimento effettuato con successo</div>";
    	} else {
    		echo "<div class='alert alert-danger' role='alert'>Errore: ".$conn->error."<br/>".$sql."</div>";
    	}
    }
?>
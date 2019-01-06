<?php
    require_once("../../php/database.php");
    require_once("db-info.php");
    $sql = "";
    if(isset($_POST["table"]) && isset($_GET["id"])) {
        $id = $_GET["id"];
    	$table = $_POST["table"];
    	$sql = "UPDATE ".$table." SET ";
    	$first = true;
    	foreach($_POST as $key => $value) {
    		if($first == true) {
    			$first = false;
    		} else {
    			$sql = $sql.$key." = '".$value."',";
    		} 
    	}
    	$sql = substr($sql, 0, -1)." WHERE ".$PRIMARY_KEYS[$table]." = ".$id;
    	$result = $GLOBALS["conn"]->query($sql);
    	if($result) {
    		echo "<div class='alert alert-success' role='alert'>Inserimento effettuato con successo</div>";
    	} else {
    		echo "<div class='alert alert-danger' role='alert'>Errore: ".$conn->error."<br/>".$sql."</div>";
    	}
    } else {
        echo "<div class='alert alert-danger' role='alert'>Errore: argomenti non validi<br/>".$sql."</div>";
    }
?>
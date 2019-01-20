<?php
    require_once("../../php/database.php");
    require_once("db-info.php");
    require_once("../../php/utilities/file_uploader.php");

    if(isset($_POST["table"])) {
    	$table = $_POST["table"];

        if(isset($_FILES["image"]) && !empty($_FILES["image"])) {
            $filePath = $table == "fornitore" ? "../../res/suppliers/" : "../../res/clients/";
            $fileName =  basename($_FILES["image"]["name"]);
            $tempArrayName = explode(".", $fileName);
            $GLOBALS["newFileName"] = $tempArrayName[0].uniqid(mt_rand(1, mt_getrandmax()), false).".".$tempArrayName[1];
            $image_uploaded =uploadFile($filePath, $GLOBALS["newFileName"], "image", $fileError);
        } else {
            $image_uploaded = false;
        }

    	$sql = "INSERT INTO ".$table."(";
    	$first = true;
        if($table == "cliente" || $table == "fornitore") {
            $random_salt = "";
            $password = "";
        }
    	foreach($_POST as $key => $value) {
    		if($first == true) {
    			$first = false;
    		} else {
                if(($table == "cliente" || $table == "fornitore") && $key == "password") {
                    // Crea una chiave casuale
                    $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                    // Crea una password usando la chiave appena creata.
                    $password = hash('sha512', $value.$random_salt);
                    $sql = $sql."salt,";
                }
                $sql = $sql.$key.",";
    		} 
    	}
        if($image_uploaded) {
            $sql = $sql."immagine,";
        }
    	
    	$sql = substr($sql, 0, -1).") VALUES (";
        $first = true;
    	foreach($_POST as $key => $value) {
    		if($first == true) {
    			$first = false;
    		} else {
	    		$plus = 0;
	    		if(is_numeric($value)) {
					$sql = $sql.$value.",";
					$plus = -1;
	    		} else {
                    if(($table == "cliente" || $table == "fornitore") && $key == "password") {
                        $sql = $sql."'".$random_salt."',"; 
                        $value = $password;
                    }
                    $sql = $sql."'".$value."',"; 
		    		$plus = -1;
		    	}
		    }
    	}
        if($image_uploaded) {
            $sql = $sql."'".$GLOBALS["newFileName"]."',"; 
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
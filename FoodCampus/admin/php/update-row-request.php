<?php
    require_once("../../php/database.php");
    require_once("db-info.php");
    require_once("../../php/utilities/file_uploader.php");

    $sql = "";
    if(isset($_POST["table"]) && isset($_GET["id"])) {
        $id = $_GET["id"];
    	$table = $_POST["table"];

        if(isset($_FILES["image"]) && !empty($_FILES["image"])) {
            $filePath = $table == "fornitore" ? "../../res/suppliers/" : "../../res/clients/";
            $fileName =  basename($_FILES["image"]["name"]);
            $tempArrayName = explode(".", $fileName);
            $GLOBALS["newFileName"] = $tempArrayName[0].uniqid(mt_rand(1, mt_getrandmax()), false).".".$tempArrayName[1];
            $image_uploaded = uploadFile($filePath, $GLOBALS["newFileName"], "image", $fileError);
        } else {
            $image_uploaded = false;
        }

    	$sql = "UPDATE ".$table." SET ";
    	$first = true;
        $no_password = false;
    	foreach($_POST as $key => $value) {
    		if($first == true) {
    			$first = false;
    		} else {
                if(is_numeric($value)) {
                    $sql = $sql.$key." = ".$value.",";
                } else {
                    if(($table == "cliente" || $table == "fornitore") && $key == "password") {
                        //check if password is chaged
                        $stmt = $conn->prepare("SELECT password FROM ".$table." WHERE ".$PRIMARY_KEYS[$table]." = ".$id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            if($row['password'] != $value) {
                                // Crea una chiave casuale
                                $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                                // Crea una password usando la chiave appena creata.
                                $value = hash('sha512', $value.$random_salt);
                                $sql = $sql."salt = '".$random_salt."',";
                            } else {
                                $no_password = true;
                            }
                        }   
                    }
                    if(!($key == "password" && $no_password)) {
                        $sql = $sql.$key." = '".$value."',";
                    }
                }
    		} 
    	}

        if($image_uploaded) {
            $sql = $sql."immagine = '".$GLOBALS["newFileName"]."',";
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
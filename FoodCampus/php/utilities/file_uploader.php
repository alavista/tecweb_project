<?php

    function uploadFile($target_dir, $fileName, $inputName, &$fileError) {

        $target_file = $target_dir . $fileName;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES[$inputName]["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
        } else {
            $fileError = "File is not an image.";
            return false;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $fileError =  "Sorry, file already exists.";
            return false;
        }
        // Check file size
        if ($_FILES[$inputName]["size"] > 3000000) { // 3 MB
            $fileError =  "Sorry, your file is too large.";
            return false;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $fileError =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            return false;
        }

		if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $target_file)) {
                //$fileError =  "The file ". basename( $_FILES[$inputName]["name"]). " has been uploaded.";
				return true;
		} else {
			$fileError = "Sorry, there was an error uploading your file.";
			return false;
		}

		return false;
    }
?>

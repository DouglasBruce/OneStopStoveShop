<?php
	$UploadName = $_FILES['images']['name'];
	//$UploadName = mt_rand(100000, 999999).$UploadName;
	$UploadTmp = $_FILES['images']['tmp_name'];
	$UploadType = $_FILES['images']['type'];
	$imageFileType = pathinfo($UploadName, PATHINFO_EXTENSION);
	$FileSize = $_FILES['images']['size'];

	$UploadName = preg_replace("#[^A-Za-z0-9\_\-.]#i", "", $UploadName);

	$directory = "assets/";
	$file = $directory . $UploadName;
	$uploadOk = 9;
	
	if(!$UploadTmp){
		echo json_encode(['error'=>'No image found for upload.']); 
		return;
	} else {
		
		// Check if image file is a actual image or fake image
		if(isset($_POST["UploadButton"])) {
			$check = getimagesize($UploadTmp);
			if($check !== false) {
				$uploadOk = 9;
			} else {
				$uploadOk = 0;
			}
		}
		
		// Check if file already exists
		if (file_exists($file)) {
			$uploadOk = 1;
		}
		
		// Check file size
		if ($FileSize > 3500000) {
			$uploadOk = 2;
		}
		
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			$uploadOk = 3;
		}
		
		if($uploadOk == 0){
			$output = ['error'=>'Error while uploading image. File isn\'t an image.'];
		} else if($uploadOk == 1){
			$output = ['error'=>'Error while uploading image. File already exists.'];
		} else if($uploadOk == 2){
			$output = ['error'=>'Error while uploading image. File too large'];
		} else if($uploadOk == 3){
			$output = ['error'=>'Error while uploading image. Only JPG, JPEG, PNG & GIF files are allowed.'];
		} else { // if everything is ok, try to upload file
			if (move_uploaded_file($UploadTmp, $file)) {
				$output = ['uploaded'=>$UploadName];
				echo "The image ". basename($UploadName). " has been uploaded.";
			} else {
				$output = ['error'=>'Error while uploading image. Contact the system administrator.'];
			}
		}
	}
	
	// return a json encoded response for plugin to process successfully
	echo json_encode($output);
?>
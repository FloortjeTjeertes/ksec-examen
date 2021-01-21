<?php
/**
 * Created by PhpStorm.
 * User: florianmac
 * Date: 21/01/2021
 * Time: 20:47
 */
if(isset($_POST['title']) && isset($_POST['description'])) {

	$file        = $_FILES;
	$title       = $_POST['title'];
	$description = $_POST['description'];
	$id = $_SESSION['userid'];
	echo $title;
	echo $description;
	echo $id;
	print_r( $file);


	$target_dir = "/user/video/";
	$target_file = $target_dir . basename($file["video"]["name"]);
	$uploadOk = 1;
	$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


		$check = filesize($file["video"]["tmp_name"]);
		if($check !== false) {
			echo "ready for upload " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "please upload a video file";
			$uploadOk = 0;
		}


		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}

	if($fileType != "ogg" && $fileType != "mp4" && $fileType != "webm") {
		echo "Sorry, only ogg, mp4 & webm  files are allowed.";
		$uploadOk = 0;
	}


	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	} else {
		if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {




			echo "The file ". htmlspecialchars( basename( $_FILES["video"]["name"])). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}

}




//function upload(){}


?>



<form id="upload" action="./user.php" method="post" enctype="multipart/form-data">
	<input type="file" required  name="video" accept=".mp4,.webm,.oog"><br>
	<input type="text" placeholder="title" name="title" required><br>
	<textarea  name="description" form="upload">description</textarea>
	<br>
	<input type="submit" value="Submit">



</form>

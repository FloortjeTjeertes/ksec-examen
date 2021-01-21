<?php
/**
 * Created by PhpStorm.
 * User: florianmac
 * Date: 21/01/2021
 * Time: 13:53
 */

searchDisplay();

if( isset($_POST['like'])&&isset($_POST['id'])){
like($_POST['like'],$_POST['id']);
}


function searchDisplay(){

	echo "<script>let videos=[]; </script>";
	foreach ( getvideos() as $video ) {
		echo "Titel: ".$video['titel'].'<br>';
		echo "<video width='400px' height='auto' controls >
  <source src='./video/".$video['videoPath']."' type='video/mp4'></video> 
    <source src='./video/".$video['videoPath']."' type='video/ogg'></video> 
  <source src='./video/".$video['videoPath']."' type='video/webm'></video> 

  
  <br>";
        echo "user:".$video['user']." likes:".$video['likes']."<h onclick='like(true,".$video['id'].")'> 👍</h> <br>";
        echo  $video['description'];
        echo "<script> videos.push(".$video['id'].") </script>";
		echo'<br>';
	}
	echo "<script type='text/javascript' src='nonuser/javascript/videoextra.js'></script>";

}



function getvideos( $name = null ) {
	$name       = "%$name%";
	$servername = 'localhost';
	$user       = "root";
	$database   = "videoBox";
	$tabel      = "video";
	$pass       = null;


	try {
		$conn = new PDO( "mysql:host=$servername;dbname=$database", $user, $pass );
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


		$sql       = 'SELECT video.id, video.videoPath,video.titel,video.description,video.likes,users.user FROM `video` 
			  INNER JOIN users on video.userId = users.id
';
		$statement = $conn->prepare( $sql );


		$statement->bindParam( ':des', $name, PDO::PARAM_STR );

		$statement->bindParam( ':titel', $name, PDO::PARAM_STR );
		$statement->execute();

		return $statement->fetchAll();


	} catch ( PDOException $e ) {
		echo "Error: " . $e->getMessage();
	}
}



function like( $add ,$id) {
	$servername = 'localhost';
	$user       = "root";
	$database   = "videoBox";
	$tabel      = "video";
	$pass       = null;


	try {
		$conn = new PDO( "mysql:host=$servername;dbname=$database", $user, $pass );
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	if($add) {
	$sql = 'UPDATE video SET likes=likes+1 WHERE id=:id';
	}
	else {
	$sql = 'UPDATE video SET likes=likes-1 WHERE id=:id';
	}

		$statement = $conn->prepare( $sql );


		$statement->bindParam( ':id', $id, PDO::PARAM_STR );

		$statement->execute();


	} catch ( PDOException $e ) {
		echo "Error: " . $e->getMessage();
	}
}


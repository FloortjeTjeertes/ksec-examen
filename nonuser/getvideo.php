<?php
/**
 * Created by PhpStorm.
 * User: florianmac
 * Date: 21/01/2021
 * Time: 13:53
 */



function getvideos($){
	$servername='localhost';
	$user="root";
	$database="videoBox";
	$tabel="video";
	$pass=null;


	try {
		$conn = new PDO( "mysql:host=$servername;dbname=$database", $user, $pass );
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


		$sql="INSERT INTO users (mail, user, pass,type)
				  VALUES (:mail, :user, :password,'1')";
		$statement = $conn->prepare( $sql );


		$statement->bindParam( ':mail', $Mail, PDO::PARAM_STR );

		$statement->bindParam( ':user', $userName, PDO::PARAM_STR );
		$statement->bindParam( ':password', $password, PDO::PARAM_STR );
		$statement->execute();
		return $statement->fetch();



	}
	catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	}
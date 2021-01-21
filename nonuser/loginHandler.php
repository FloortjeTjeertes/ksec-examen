<?php
/**
 * Created by PhpStorm.
 * User: florianmac
 * Date: 28/12/2020
 * Time: 14:15
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'mailValidation.php';




 $user =$_POST['name'];


$Email = $_POST['email'];
$pass = $_POST['pass'];
$submit = $_POST['submit'];

  $jsonresult=[
  	'validate'=> validate($Email,$pass),
	'exist'=>false,
	  'url'=>'index.php',
	  'register'=>false,
	 'debug'=>null,
    'debug2'=>null
  ];





if(isset($submit)&&$submit=='true'){


	if($user==null) {

		$get = databaseGet( $Email, $pass );


		if ( $get == false ) {

			$jsonresult['debug'] = $get;
			$jsonresult['exist'] = false;
		} else {

			$jsonresult['debug'] = $get;
			$jsonresult['exist'] = true;
			$jsonresult['url']   = sesionHandle( $get['type'], $get['user'] );


		}
	}
	else{
		$get = databaseGet( $Email, $pass );
		$jsonresult['debug']=$get;


		if ( $get == false ) {


			$jsonresult['debug2'] = "available";
			$jsonresult['register'] = "true";

			$jsonresult['exist'] = false;



			databaseGet( $Email, $pass,true,$user );
		} else {

			$jsonresult['debug2'] = "not available";
			$jsonresult['register'] = "true";
			$jsonresult['exist'] = true;


		}




	}
}




function validate($email,$password) {

	if ( isset( $email ) && isset( $password ) ) {

		if ($password!=""&&$email!="") {
			return true;
		}


		else{
			return false;
		}
	}
	else{
		return false;
	}
}


function sesionHandle($userType,$user){
	session_start();
	$_SESSION["ID"]=session_id();
	$_SESSION["userName"]=$user;
	$_SESSION["userType"]=$userType;


	if($userType=='admin'){

		return '../admin/admin.php';

	}
	elseif ($userType=='user'){
		return '../user/user.php';



	}
	else{

		return'../login.php';

	}

}








function databaseGet($Mail,$password,$register=false,$userName=null) {

	$servername='localhost';
	$user="root";
	$pass=null;
	$database="videoBox";
	$sql=null;
	try {
		$conn = new PDO( "mysql:host=$servername;dbname=$database", $user, $pass );
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if($register==false) {
			$sql = "SELECT users.mail,users.user,users.pass , roles.type FROM users 
					INNER JOIN roles on users.type = roles.id WHERE mail=:mail AND pass=:password";
		}

		else {
				$sql = "INSERT INTO users (mail, user, pass,type)
				  VALUES (:mail, :user, :password,'1')";

		}

		$statement = $conn->prepare( $sql );


		if($register==true) {
			$statement->bindParam( ':mail', $Mail, PDO::PARAM_STR );

			$statement->bindParam( ':user', $userName, PDO::PARAM_STR );
			$statement->bindParam( ':password', $password, PDO::PARAM_STR );
			$statement->execute();
		}
		else {
			$statement->bindParam( ':mail', $Mail, PDO::PARAM_STR );
			$statement->bindParam( ':password', $password, PDO::PARAM_STR );
			$statement->execute();
		}
			return $statement->fetch();

	}
	catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
	}

}

header('Content-Type: application/json');
echo json_encode($jsonresult) ;
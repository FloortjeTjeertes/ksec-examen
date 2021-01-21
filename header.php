<?php
/**
 * Created by PhpStorm.
 * User: florianmac
 * Date: 21/01/2021
 * Time: 11:10
 */

$loginUrl = ["/video-box-sec/nonuser/login.php","/video-box-sec/admin/admin.php","/video-box-sec/user/user.php"];
$logOff=null;
$account=null;
$i =0;
@session_start();

		if ( isset( $_SESSION["userName"] ) ) {
			$name        = $_SESSION["userName"];
			$accountType = $_SESSION["userType"];


			if ( $accountType == 'admin' ) {
				$i = 1;
			}
			if ( $accountType == 'user' ) {
				$i = 2;
			}

			$url= $_SERVER['PHP_SELF'];


			$account ="<a href='$loginUrl[$i]'>$accountType $name </a>";

			$logOff = "
	<form  action='$url' method='post'>
	
	<input type='hidden' name='destroy' value='true'>
	<input type='submit' value='log off'>

	</form>
	";

		}



 if ($_SERVER["REQUEST_METHOD"] === "POST" &&isset( $_POST['destroy'] ) )
{
	session_destroy();
	$name        = "login/register";
	$accountType = null;
	echo "<script>
	
	location.href='../index.php';
	</script>";
}
elseif(!isset( $_SESSION["userName"] )){
	$name        = "login/register";
	$accountType = null;
	$account ="<a href='$loginUrl[0]'>$accountType $name </a>";

}
?>
<body>
<head>
	<?php
	echo $account;
	?>

	<?php
	echo $logOff;
	?>
</head>

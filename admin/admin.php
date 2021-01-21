<?php
session_start();

if(!isset($_SESSION["ID"])&&!isset($_SESSION["STATUS"])){
	echo "<script>

location.href='../index.php';
</script>
";


}
include "../header.php";
echo "admin";
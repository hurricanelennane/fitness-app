<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../config.php");
if($_SERVER['REQUEST_METHOD'] == "GET"){
	if(!array_key_exists("tentName",$_GET)){
		header("HTTP/1.0 400 Bad Request");
		print("Bad params");
		exit();
	}
	$check = $_GET['tentName'];
	$chkUser = $conn -> prepare("SELECT * FROM user WHERE username=?") or die($conn -> error);
	$chkUser -> bind_param("s",$check) or die($conn -> error);
	$chkUser -> execute();
	$res = $chkUser->get_result();
	print(json_encode(!$res -> num_rows>0));
}
?>
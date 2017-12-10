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
else if($_SERVER['REQUEST_METHOD']=="POST"){
	$params = json_decode(file_get_contents('php://input'),true);
	//$params = $_POST;
	if(!(array_key_exists("username",$params) && array_key_exists("password",$params))){
		header("HTTP/1.0 400 Bad Request");
		print("Bad params");
		exit();
	}
	$user = $params['username'];
	$pass = password_hash($params['password'],PASSWORD_DEFAULT);
	$registerUser = $conn -> prepare("INSERT INTO user(id, username, password, email) VALUES (NULL, ?, ?, NULL)");
	$registerUser -> bind_param("ss",$user, $pass);
	if(!$registerUser -> execute()){
		header("HTTP/1.0 500 Internal Server Error");
		print(json_encode("db Error"));
	}
	else{
		print(json_encode(true));
	}
}
?>
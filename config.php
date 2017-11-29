<?php
ob_start();
session_start();
date_default_timezone_set('America/New_York');

//db credentials
define("DB_HOST","localhost:3306");
define("DB_USER","gainz_app");
define("DB_PASS","i_heart_kmp");
define("DB_NAME","gainz_db");

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($conn -> connect_errno){
	echo "db error: ".$conn -> connect_error;
	exit();
}
?>
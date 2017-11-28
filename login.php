<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
session_start();
date_default_timezone_set('America/New_York');

//db credentials
define("DB_HOST","localhost:8889");
define("DB_USER","gainz_app");
define("DB_PASS","i_heart_kmp");
define("DB_NAME","gainz_db");

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn -> real_query("SELECT * FROM user");
$res = $conn -> use_result();
$row = $res -> fetch_assoc();
echo $row['username'];
?>
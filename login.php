<?php
require_once("config.php");
session_start();
if(isset($_SESSION["userID"])){
	header("location: index.php");
	exit();
}
if ($_SERVER['REQUEST_METHOD'] == "POST"){
	$user = $_POST['username'];
	$pass = $_POST['password'];
	$chkUser = $conn -> prepare("SELECT * FROM user WHERE username=?") or die($conn -> error);
	$chkUser -> bind_param("s",$user) or die($conn -> error);
	$chkUser -> execute();
	$res = $chkUser->get_result();
	if($res -> num_rows ==1){
		$row = $res -> fetch_assoc();
		if(password_verify($pass, $row["password"])){
			header("location: index.php");
			$_SESSION["userID"] = $row["id"];
		}
		else{
			$error = "Password invalid";
		}
	}
	else{
		$error = "Invalid username";
	}
}
?>
<html>
	<head>
		<link href='https://fonts.googleapis.com/css?family=Kumar One' rel='stylesheet'>
		<link rel="stylesheet" type="text/css" href="main.css">
		<title>Login</title>
	</head>
	<body>
		<div class='header'>
			<h1>GAINZ<h1>
		</div>
		<div class="loginDiv">
			<h3>Login</h3>
			<form action="" method="POST">
				<label>Username: </label><input tabindex=1 type="text" name="username" placeholder:'Enter Username'></input><br>
				<label>Password: </label><input tabindex=2 type="password" name="password"></input><br>
				<input tabindex=3 type="submit" value="Submit" id='enter'></input></form><br>
				<p><?php echo $error;?></p>
				<a id='register' href="register.html">No login? Register here.</a>
			</form>
		</div>
	</body>
</html>
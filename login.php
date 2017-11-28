<?php
require("config.php");
session_start();
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
		<link rel="stylesheet" type="text/css" href="main.css">
		<title>Login</title>
	</head>
	<body>
		<div id="loginDiv">
			<h1>Login</h1>
			<form action="" method="POST">
				<label>Username: </label><input tabindex=1 type="text" name="username"></input><br>
				<label>Password: </label><input tabindex=2 type="password" name="password"></input><br>
				<input tabindex=3 type="submit" value="submit"></input></form><br>
				<p><?php echo $error;?></p>
			</form>
		</div>
	</body>
</html>
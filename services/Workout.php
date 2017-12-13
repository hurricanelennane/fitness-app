<?php 						
require_once("../orm/Exercise.php");
require_once("../orm/Workout.php");
@session_start();
@$path = explode("/", $_SERVER["PATH_INFO"]);
if(!isset($_SESSION["userID"])){
	print(json_encode("Please Authenticate"));
	exit();
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
	if(count($path) > 1 && $path[1] != ""){
		if(strtolower($path[1]) == "user"){
			if(count($path)>2){
				$workout = Workout::getByID((int)$path[2]);
				if(!$workout){
					header("HTTP/1.0 404 Not Found");
					exit();
				}
				print(json_encode($workout -> isLinked($_SESSION["userID"])));
				exit();
			}
			print(json_encode(Workout::getWorkoutsByUser($_SESSION["userID"])));
			exit();
		}
		else{
			$workout = Workout::getByID((int)$path[1]);
			if(!$workout){
				print("Workout id not found");
				header("HTTP/1.0 404 Not Found");
				exit();
			}
			else{
				print(json_encode($workout -> getExercises()));
				exit();
			}
		}
	}
	else{
		print(json_encode(Workout::getAll()));
		exit();
	}
}
else if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$stdin = file_get_contents('php://input');
	$params = $stdin == ""? $_POST:json_decode($stdin,true);
	if(count($path) > 1 && $path[1] != ""){
		$workout = Workout::getByID((int)$path[1]);
		if(!$workout){
			print("false");
			header("HTTP/1.0 404 Not Found");
		}
		else{
			if(count($path) >2 && $path[2] == "link"){
				print(json_encode($workout -> linkToUser($_SESSION["userID"])));
				exit();
			}
			if($params["name"]!="")
				$workout -> setName($params["name"]);
			if($params["description"]!="")
				$workout -> setDescription($params["description"]);
			if($params["intensity"]!="")
				$workout -> setIntensity($params["intensity"]);
			print(json_encode($workout -> update()));
		}
	}
	else{
		if($params["name"]!="" && $params["description"]!="" && $params["intensity"]!=""){
			$newWorkout = Workout::create($params["name"],$params["description"],$params["intensity"], $_SESSION["userID"]);
			print(json_encode($newWorkout =! null? $newWorkout:false));
			exit();
		}
		else{
			header("HTTP/1.0 400 Bad Request");
			exit();
		}		
	}
}
else if ($_SERVER["REQUEST_METHOD"] == "DELETE"){
	$params = json_decode(file_get_contents('php://input'));
	if(!$params)
		$params = $_POST;
	if($path[1] != ""){
		$workout = Workout::getByID((int)$path[1]);
		if(!$workout){
			header("HTTP/1.0 404 Not Found");
		}
		else if($_SESSION["userID"] == $workout -> getCreatedBy()){
			print(json_encode($workout -> delete((int)$path[1])));
		}
		else{
			header("HTTP/1.0 403 Forbidden");
			print(json_encode(false));
		}
 
	}
}
else if ($_SERVER["REQUEST_METHOD"] == "OPTIONS"){
	$options = array();
	if(count($path)>1 && $path[1] != ""){
		$workout = Workout::getByID((int)$path[1]);
		if(!$workout){
			header("HTTP/1.0 404 Not Found");
			exit();
		}
		if($workout -> isLinked($_SESSION["userID"]))
			$options[] = "REMOVE";
		else
			$options[] = "ADD";
		if($workout -> getCreatedBy() == $_SESSION["userID"]){
			$options[] = "DELETE";
			$options[] = "UPDATE";
		}
		print(json_encode($options));
		exit();
	}else{
		header("400 Bad Request");
		exit();
	}

}
?>
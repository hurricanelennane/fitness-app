<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../config.php");
require_once("Exercise.php");

class Workout implements JsonSerializable{
	private $id;
	private $name;
	private $description;
	private $intensity;
	private $date_created;

	public static function create($name, $description, $intensity){
		$conn = $GLOBALS["conn"];
		$insWorkout = $conn -> prepare("INSERT INTO workout(wid, name, description, intensity, date_created) VALUES(NULL,?,?,?,NULL)");

		if(! $insWorkout -> bind_param("sss", $name, $description, $intensity))
			return null;
		if(! $insWorkout -> execute())
			return null;
		
		$resID = $conn -> insert_id;
		$datestamp = null;
		$getNewDate = $conn -> prepare("SELECT date_created FROM workout WHERE wid=?");
		if($getNewDate -> bind_param("i", $resID)){
			if($getNewDate -> execute()){
				$datestamp = $getNewDate -> get_result() -> fetch_assoc()["date_created"];
			}
		}
		return new Workout($resID, $name, $description, $intensity, $datestamp);
	}
	public static function getByID($id){
		$conn = $GLOBALS["conn"];
		$getByID = $conn -> prepare("SELECT * FROM workout WHERE wid=?");
		if(!$getByID -> bind_param("i", $id))
			return false;
		if(!$getByID -> execute())
			return false;

		$res = $getByID -> get_result();
		if($res -> num_rows == 0)
			return false;
		$res = $res -> fetch_assoc();
		return new Workout($id, $res["name"], $res["description"], $res["intensity"], $res["date_created"]);
	}
	private function __construct($id, $name, $description, $intensity, $date_created){
		$this -> id = $id;
		$this -> name = $name;
		$this -> description = $description;
		$this -> intensity = $intensity;
		$this -> date_created = $date_created;
	}
	public function delete(){
		$conn = $GLOBALS["conn"];
		$delByID = $conn -> prepare("DELETE FROM workout WHERE wid=?");
		if(!$delByID -> bind_param("i", $this -> id))
			return false;
		if(!$delByID -> execute())
			return false;
		return true;
	}
	public function update(){
		$conn = $GLOBALS["conn"];
		$update = $conn -> prepare("UPDATE workout SET name=?, description=?, intensity=? WHERE wid=?");
		if(! $update -> bind_param("sssi",$this -> name, $this -> description, $this -> intensity, $this -> id))
			return false;
		if(! $update -> execute())
			return false;
		return true;
	}
	public function getExercises(){
		return Exercise::getExercisesInWorkout($this);
	}
	public function setName($name){
		$this -> name = $name;
		return $this -> update();
	}
	public function setDescription($description){
		$this -> description = $description;
		return $this -> update();
	}
	public function setIntensity($intensity){
		$this -> intensity = $intensity;
		return $this -> update();
	}
	public function getName(){
		return $this -> name;
	}
	public function getID(){
		return $this -> id;
	} 
	public function getDescription(){
		return $this -> description;
	} 
	public function getIntensity(){
		return $this -> intensity;
	} 
	public function getDateCreated(){
		return $this -> date_created;
	}  
	public function jsonSerialize(){
	    return    ["id" => $this -> id,
	               "name" => $this -> name,
	               "description" => $this -> description,
	               "intensity" => $this -> intensity,
	               "date_created" => $this -> date_created];
	}
}
$test = Workout::getByID(7);
echo json_encode($test -> getExercises());
?>
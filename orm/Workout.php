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
	private $created_by;

	public static function create($name, $description, $intensity, $creator){
		$conn = $GLOBALS["conn"];
		$insWorkout = $conn -> prepare("INSERT INTO workout(wid, name, description, intensity, date_created, created_by) VALUES (NULL,?,?,?,NULL,?)");
		if(! $insWorkout -> bind_param("sssi", $name, $description, $intensity, $creator))
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
		$workout = new Workout($resID, $name, $description, $intensity, $datestamp, $creator);
		$workout -> linkToUser($creator);
		return $workout;
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
		return new Workout($id, $res["name"], $res["description"], $res["intensity"], $res["date_created"], $res["created_by"]);
	}

	public static function getWorkoutsByUser($uid){
		$conn = $GLOBALS["conn"];
		$outArray = array();
		$getByUser = $conn -> prepare("SELECT workout.* FROM workout 
									INNER JOIN userworkout ON workout.wid = userworkout.wid
									INNER JOIN user ON user.id = userworkout.uid
									WHERE user.id = ?");
		if(!$getByUser -> bind_param("i", $uid))
			return false;
		if(!$getByUser -> execute())
			return false;

		$res = $getByUser -> get_result();
		while($row = $res -> fetch_assoc()){
			$outArray[] = new Workout($row["wid"], $row["name"], $row["description"], $row["intensity"], $row["date_created"], $row["created_by"]);
		}
		return $outArray;
	}

	public static function getAll(){
		$conn = $GLOBALS["conn"];
		$conn->real_query("SELECT * FROM workout ORDER BY date_created DESC");
		$res = $conn->use_result();
		$outArray = array();
		while($row = $res -> fetch_assoc()){
			$outArray[] = new Workout($row["wid"], $row["name"], $row["description"], $row["intensity"], $row["date_created"], $row["created_by"]);
		}
		return $outArray;
	}

	private function __construct($id, $name, $description, $intensity, $date_created, $created_by){
		$this -> id = $id;
		$this -> name = $name;
		$this -> description = $description;
		$this -> intensity = $intensity;
		$this -> date_created = $date_created;
		$this -> created_by = $created_by;
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
	public function isLinked($uid){
		$conn = $GLOBALS["conn"];
		$isLinked = $conn -> prepare("SELECT * FROM userworkout WHERE uid = ? AND wid =?");
		if(! $isLinked -> bind_param("ii", $uid, $this -> id))
			return false;
		if(! $isLinked -> execute())
			return false;
		return $isLinked -> get_result() -> num_rows > 0;
	}
	public function linkToUser($uid){
		$conn = $GLOBALS["conn"];
		$update = $conn -> prepare("INSERT INTO userworkout(uid, wid, date_added, active_flag) VALUES (?,?,NULL,0)");
		if(! $update -> bind_param("ii",$uid, $this->id))
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
	public function getCreatedBy(){
		return $this -> created_by;
	}
	public function jsonSerialize(){
	    return    ["id" => $this -> id,
	               "name" => $this -> name,
	               "description" => $this -> description,
	               "intensity" => $this -> intensity,
	               "date_created" => $this -> date_created];
	}
}
// $test = Workout::create("Linktest","some fuck shit","mild");
// print(json_encode($test -> linkToUser(1)));
// print(json_encode(Workout::getWorkoutsByUser(1)));
?>
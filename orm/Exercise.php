<?php
require_once("../config.php");
require_once("Workout.php");
class Exercise implements JsonSerializable{
	private $id;
	private $name;
	private $description;
	private $reps;
	private $duration;
	private $date_created;
	private $created_by;

	public static function create($name, $description, $reps, $duration, $creator){
		$conn = $GLOBALS["conn"];
		$insExercise = $conn -> prepare("INSERT INTO exercise(eid, name, description, reps, duration, date_created, created_by)
			VALUES(NULL,?,?,?,?,NULL,?)");
		if(! $insExercise -> bind_param("ssiii", $name, $description, $reps, $duration, $creator))
			return false;
		if(! $insExercise -> execute())
			return false;

		$resID = $conn -> insert_id;
		$datestamp = null;
		$getNewDate = $conn -> prepare("SELECT date_created FROM exercise WHERE eid=?");
		if($getNewDate -> bind_param("i", $resID)){
			if($getNewDate -> execute()){
				$datestamp = $getNewDate -> get_result() -> fetch_assoc()["date_created"];
			}
		}
		return new Exercise($resID, $name, $description, $reps, $duration, $datestamp);
	}

	public static function getByID($id){
		$conn = $GLOBALS["conn"];
		$getByID = $conn -> prepare("SELECT * FROM exercise WHERE eid=?");
		if(! $getByID -> bind_param("i", $id))
			return false;
		if(! $getByID -> execute())
			return false;
		$res = $getByID -> get_result();
		if($res -> num_rows ==0)
			return false;
		$res = $res -> fetch_assoc();
		return new Exercise($id, $res["name"], $res["description"], $res["reps"], $res["duration"], $res["date_created"], $res["created_by"]);
	}

	public static function getExercisesInWorkout($workout){
		$conn = $GLOBALS["conn"];
		$wid = $workout -> getID();
		$getExercises = $conn -> prepare("SELECT exercise.* FROM workout 
								  INNER JOIN workoutexercise ON workoutexercise.wid = workout.wid
								  INNER JOIN exercise ON workoutexercise.eid = exercise.eid
								  WHERE workout.wid = ?");
		if(! $getExercises -> bind_param("i", $wid))
			return false;
		if(! $getExercises -> execute())
			return false;
		$res = $getExercises -> get_result();
		$out = array();
		while($row = $res -> fetch_assoc()){
			$out[] = new Exercise($row["eid"], $row["name"], $row["description"], $row["reps"], $row["duration"], $row["date_created"], $row["created_by"]);
		}
		return $out;
	}

	private function __construct($id, $name, $description, $reps, $duration, $date_created, $created_by){
		$this -> id = $id;
		$this -> name = $name;
		$this -> description = $description;
		$this -> reps = $reps;
		$this -> duration = $duration;
		$this -> date_created = $date_created;
		$this -> created_by = $created_by;
	}

	public function delete(){
		$conn = $GLOBALS["conn"];
		$delete = $conn -> prepare("DELETE FROM exercise WHERE eid=?");
		if(!$delete -> bind_param("i", $this -> id))
			return false;
		if(!$delete -> execute())
			return false;
		return true;
	}

	public function update(){
		$conn = $GLOBALS["conn"];
		$update = $conn -> prepare("UPDATE exercise SET name=?, description=?, reps=?, duration=? WHERE eid=?");
		if(! $update -> bind_param("ssssi", $this -> name, $this -> description, $this -> reps, $this -> duration, $this -> id))
			return false;
		if(! $update -> execute())
			return false;
		echo $update -> error;
		return true;
	}

	public function setName($name){
		$this -> name = $name;
		return $this -> update();
	}
	public function setDescription($description){
		$this -> description = $description;
		return $this -> update();
	}
	public function setReps($reps){
		$this -> reps = $reps;
		return $this -> update();
	}
	public function setDuration($duration){
		$this -> duration = $duration;
		return $this -> update();
	}
	public function getID(){
		return $this -> id;
	}
	public function getName(){
		return $this -> name;
	}
	public function getDescription(){
		return $this -> description;
	}
	public function getReps(){
		return $this -> reps;
	}
	public function getDuration(){
		return $this -> duration;
	}
	public function getDateCreated(){
		return $this -> date_created;
	}
	public function getCreator(){
		return $this -> created_by;
	}
	
	public function jsonSerialize(){
		return ["id" => $this -> id,
	               "name" => $this -> name,
	               "description" => $this -> description,
	               "reps" => $this -> reps,
	               "duration" => $this -> duration,
	               "date_created" => $this -> date_created];
		return json_encode($this);
	}
}
?>
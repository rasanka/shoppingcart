<?php
require_once("config/config.php");

class DB_Manager {

	function getUID($prefix) {
		return uniqid($prefix);
	}	
	
	function getDBConnection(){
		
		global $HOST;
		global $DB;
		global $USER;
		global $PASSWORD;

		$mysqli = new mysqli($HOST,$USER,$PASSWORD,$DB);

		/* check connection */
		if (mysqli_connect_errno()) {
			printf("DB Connection failed: %s\n", mysqli_connect_error());
			exit();
		} else {
			return $mysqli;
		}	
		
	}
	/*
	function getLocalOffset(){
		define('TIMEZONE', 'Asia/Colombo');	
		date_default_timezone_set(TIMEZONE);
		
		$now = new DateTime();  
		$mins = $now -> getOffset() / 60;
		
		$sgn = ($mins < 0 ? -1 : 1);  
		$mins = abs($mins);  
		$hrs = floor($mins / 60);  
		$mins -= $hrs * 60;
		
		$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);
		
		return $offset;		
	}
	*/
	function freeDBConnection($mysqli){
		$mysqli->close();
	}
	
	function executeQuery($query){
		$mysqli = $this->getDBConnection();
		$result = $mysqli -> query($query);
		
		$results = array();
		$r=0;
		while ($row = $result -> fetch_array(MYSQLI_NUM)) {
		  $c=0;
		  foreach($row as $rs){
			$results[$r][$c]=$rs;
			$c++;
		  }
		  $r++;
		}
		$result -> free();
		$this->freeDBConnection($mysqli);
		return $results;
	}
	
	function executeDeleteQuery($query){
		$mysqli = $this->getDBConnection();
		$status = false;
		if($mysqli -> query($query) === TRUE){
			$status = true;
		}else{
			$status = false;
		}
		$this->freeDBConnection($mysqli);
		return $status;
	}
	
	function executeInsertQuery($query){
		$mysqli = $this->getDBConnection();
		$status = false;
		if($mysqli -> query($query) === TRUE){
			$status = true;
		}else{
			$status = false;
		}
		$this->freeDBConnection($mysqli);
		return $status;
	}

	function executeInsertQueryReturnID($query){

		//$this -> logData('Testing executeInsertQueryReturnID'.$query);
		$mysqli = $this->getDBConnection();
		$last_id = 0;

		if ($mysqli->query($query) === TRUE) {
			$last_id = $mysqli->insert_id;
			//$this -> logData("New record created successfully. Last inserted ID is: " . $last_id);
		} 

		$this->freeDBConnection($mysqli);
		return $last_id;
	}	
	
	function executeUpdateQuery($query){
		$mysqli = $this->getDBConnection();
		$status = false;
		if($mysqli -> query($query) === TRUE){
			$status = true;
		}else{
			$status = false;
		}
		$this->freeDBConnection($mysqli);
		return $status;
	}
	
	function logData($data){
		
		$log_path = "C:\\wamp64\\www\\phonerepairparts\\logs\\";
		$file_name = $log_path. date("Y_m_d").".txt";
		$data = $data." \r\n";
		$file = fopen($file_name, "a");
		fwrite($file, $data);
		fclose($file);
	}
	
	function dateconvert($date,$func){
		if ($func == 1){ //insert conversion
			list($month, $day, $year) = split('[/.-]', $date);
			$date = "$year-$month-$day";
			return $date;
		}if ($func == 2){ //output conversion
			list($year, $month, $day) = split('[-.]', $date);
			$date = "$month/$day/$year";
			return $date;
		}
	} 
	
}


?>

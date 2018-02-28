<?php
require_once("config/config.php");

class DB_Manager {
	
	function getDBConnection(){
		
		global $HOST;
		global $DB;
		global $USER;
		global $PASSWORD;
		
			$con = mysql_connect($HOST,$USER,$PASSWORD,$DB);
			mysql_select_db($DB,$con);
			
			$offset = $this->getLocalOffset();
			mysql_query("SET time_zone = '".$offset."'");
			
			if(!$con){
				echo "Database connection error...".mysql_error();
			}else{
		    	//echo "Database connection Success...";
		 		return $con;
			}
	}
	
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
	
	function freeDBConnection($con){
		mysql_close($con);
	}
	
	function executeQuery($query){
		$con = $this->getDBConnection();
		$result = mysql_query($query);
		
		$results = array();
		$r=0;
		while ($row = mysql_fetch_array($result,MYSQL_NUM)) {
		  //$results[$n]['id'] = $row['Email_id'];
		  $c=0;
		  foreach($row as $rs){
			$results[$r][$c]=$rs;
			$c++;
		  }
		  $r++;
		}
		mysql_free_result($result);
		$this->freeDBConnection($con);
		return $results;
	}
	
	
	function executeDeleteQuery($query){
		$con = $this->getDBConnection();
		$status = false;
		if(mysql_query($query)){
			$status = true;
		}else{
			$status = false;
		}
		$this->freeDBConnection($con);
		return $status;
	}
	
	function executeFunction($query){
		$con = $this->getDBConnection();
		$result = mysql_query($query);
		$returnval = "";
		while ($row = mysql_fetch_array($result,MYSQL_NUM)) {
			$returnval = $row[0];			
		}
		mysql_free_result($result);
		$this->freeDBConnection($con);
		return $returnval;
	}	
	
	function executeProcedure($query){
		$con = $this->getDBConnection();
		$status = false;
		if(mysql_query($query)){
			$status = true;
		}else{
			$status = false;
		}
		$this->freeDBConnection($con);
		return $status;
	}	
	
	function executeInsertQuery($query){
		$con = $this->getDBConnection();
		$status = false;
		if(mysql_query($query)){
			$status = true;
		}else{
			$status = false;
		}
		$this->freeDBConnection($con);
		return $status;
	}
	
	function executeInsertQueryReturnID($query){
		$con = $this->getDBConnection();
		$id = 0;
		if(mysql_query($query)){
			$id = mysql_insert_id();
		}else{
			$id = 0;
		}
		$this->freeDBConnection($con);
		return $id;
	}	
	
	
	function executeUpdateQuery($query){
		$con = $this->getDBConnection();
		$status = false;
		if(mysql_query($query)){
			$status = true;
		}else{
			$status = false;
		}
		$this->freeDBConnection($con);
		return $status;
	}
	
	function logData($data){
		
		$log_path = "C:\\wamp64\\www\\phonerepairparts\\admin\\logs\\";
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

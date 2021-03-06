<?php
 
class Common extends DB_Manager{

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
	
	function logData($data){
		
		$log_path = "C:\\wamp64\\www\\phonerepairparts\\logs\\";
		$file_name = $log_path. date("Y_m_d").".txt";
		$data = $data." \r\n";
		$file = fopen($file_name, "a");
		fwrite($file, $data);
		fclose($file);
	}


	function curPageURL() {
		
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
}
?>

<?php
require_once("db_manager.class.php");

class NewsLetter extends DB_Manager { 
	
	function saveSubscribeEmail($email){

		$query = "INSERT INTO tbl_newsletter_signup (email,added_date) 
				  VALUES('".$email."',now()); ";

		$result = "";
		$result = $this -> executeInsertQuery($query);
						
		return $result;
	}


	function saveContactUsInquiry($name,$company,$email,$subject,$message){
		
		$query = "  INSERT INTO tbl_web_inquiry 
					(inq_id, name, email, company, subject, message, inq_date)
					VALUES('".$this -> getUID('Q')."','".$name."','".$email."','".$company."','".$subject."','".$message."',now());  ";
									
		$result = "";
		$result = $this -> executeInsertQuery($query);	

		return $result;
	}	

}
?>

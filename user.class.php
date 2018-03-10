<?php
require_once("db_manager.class.php");

class User extends DB_Manager { 

	function checkEmail($email){
	
		$query = " 	SELECT COUNT(user_id) 
					FROM tbl_users 
					WHERE UPPER(email) = '".strtoupper($email)."'; ";
		
		$result = array();		   
		$result = $this -> executeQuery($query);
		
		$count = 0;	
		$count = $result[0][0];
		return $count;
	}	
	
	function saveUser($fname,$lname,$email,$contact,$password,$houseNo,$street,$city,$region,$postal,$country){

		//if(!isset($houseNo) || empty($houseNo)) { $houseNo = 'null'; }
	
		$user_id  = $this -> getUID('U');
		$query = "INSERT INTO tbl_users (user_id,first_name,last_name,email,contact_no,password,billing_house_no,billing_street,billing_city,billing_region,billing_postal_code,billing_country,registered_date,user_status) 
				  VALUES('".$user_id."','".$fname."','".$lname."','".$email."','".$contact."','".$password."','".$houseNo."',NULLIF('".$street."',''),NULLIF('".$city."',''),NULLIF('".$region."',''),NULLIF('".$postal."',''),'".$country."',now(),'INACTIVE'); ";

		//$userId = 0;
		$result = $this -> executeInsertQuery($query);
		if($result) {	
			return $user_id;
		} else {
			return 'ERROR';
		}
	}

	function updateUserPassword($user_id, $password) {
		$query = "  UPDATE tbl_users 
                    SET password = '".$password."'
                    WHERE user_id = '".$user_id."'; ";

        $result = $this -> executeUpdateQuery($query);  
        return $result;
	}

    function activateUser($user_id) {

        $query = "  UPDATE tbl_users 
                    SET user_status = 'ACTIVE'
                    WHERE user_id = '".$user_id."'; ";

        $result = $this -> executeUpdateQuery($query);  
        return $result;
    } 	

	function validateLogin($username,$password){
	
		$query = " SELECT first_name,user_id, email 
				   FROM tbl_users 
				   WHERE UPPER(email) = UPPER('".$username."') AND 
				 		 UPPER(password)  = UPPER('".$password."') AND 
						 user_status = 'ACTIVE'; ";
						 
		$result = $this -> executeQuery($query);	
		return $result;
	}

	function isInactiveLogin($username,$password){
	
		$query = " SELECT COUNT(*) 
				   FROM tbl_users 
				   WHERE UPPER(email) = UPPER('".$username."') AND 
				 		 UPPER(password)  = UPPER('".$password."') AND 
						 user_status = 'INACTIVE'; ";
						 
		$result = $this -> executeQuery($query);	
		$count = 0;	
		$count = $result[0][0];
		return $count;
	}	

	function getUserDetailsById($id){
	
		$query = "  SELECT first_name, last_name, email, contact_no, password, billing_house_no, billing_street, billing_city,
					billing_region, billing_postal_code, billing_country, registered_date, user_status
					FROM tbl_users
					WHERE user_id = '".$id."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		if(count($result) > 0){
			$details = array("fname"=>$result[0][0],"lname"=>$result[0][1],"email"=>$result[0][2],"contact"=>$result[0][3],"password"=>$result[0][4],
							 "bill_house_no"=>$result[0][5],"bill_street"=>$result[0][6],"bill_city"=>$result[0][7],"bill_region"=>$result[0][8],
							 "bill_postal_code"=>$result[0][9],"bill_country"=>$result[0][10],"reg_date"=>$this -> dateconvert($result[0][11],2),
							 "status"=>$result[0][12]);
		
			return $details;
		}else{
			return "NO_DATA";
		}
	
	}	
		

	function getUserDetailsByEmail($email){
	
		$query = "  SELECT first_name, last_name, email, contact_no, password, billing_house_no, billing_street, billing_city,
					billing_region, billing_postal_code, billing_country, registered_date, user_status
					FROM tbl_users
					WHERE UPPER(email) = '".strtoupper($email)."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		if(count($result) > 0){
			$details = array("fname"=>$result[0][0],"lname"=>$result[0][1],"email"=>$result[0][2],"contact"=>$result[0][3],"password"=>$result[0][4],
							 "bill_house_no"=>$result[0][5],"bill_street"=>$result[0][6],"bill_city"=>$result[0][7],"bill_region"=>$result[0][8],
							 "bill_postal_code"=>$result[0][9],"bill_country"=>$result[0][10],"reg_date"=>$this -> dateconvert($result[0][11],2),
							 "status"=>$result[0][12]);
		
			return $details;
		}else{
			return "NO_DATA";
		}
	
	}			

}
?>

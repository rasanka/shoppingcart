<?php
	include_once ("config/config.php");	
	//require_once("user.class.php");
	
	//$userObj = new User();
	
	$m_chksql   = $_GET['chksql'];
	
	if ($m_chksql == "validate") {
	
		$user_name  = $_GET['username'];
		$user_pass  = $_GET['password'];	
		
		//$logout = $userObj -> doAutoLogout();

		if(strtoupper("SYSADMIN") == strtoupper($user_name) && strtoupper($ADMIN) == strtoupper($user_pass)){
			session_destroy();
			session_start();
			$_SESSION['ses_name'] = "The Administrator";
			$_SESSION['ses_user_name'] = "SYSADMIN";
			$_SESSION['ses_user_id'] = "U100999";
			$_SESSION['ses_user_level'] = "ADMIN";
			echo "OK";
    	}
		else{

			// $result = array();
			// $result = $userObj -> validateLogin($user_name,$user_pass);

			// if(count($result) > 0){
	
			// 	$val_name = '';
			// 	$val_user_name = '';
			// 	$val_id = '';		
			// 	$val_type = '';	
			
			// 	$val_name = $result[0][0];
			// 	$val_user_name = $result[0][1];
			// 	$val_id = $result[0][2];
			// 	$val_type = $result[0][3];

			// 	if(strtoupper($val_user_name) == strtoupper($user_name)){
				
			// 		$status = $userObj -> updateLogin($val_id,$val_name);
			
			// 		if($status){
			// 			session_destroy();
			// 			session_start();
			// 			$_SESSION['ses_name'] = $val_name;
			// 			$_SESSION['ses_user_name'] = $val_user_name;
			// 			$_SESSION['ses_user_id'] = $val_id;
			// 			$_SESSION['ses_user_level'] = $val_type;					
			// 			echo "OK";
			// 		}else{
			// 			echo "ERROR";	
			// 		}	
			// 	}else{
			// 		echo "ERROR";
			// 	}	
			// }else{
			// 	echo "ERROR";
			// }
			echo "ERROR";		
		}		
	}
?>

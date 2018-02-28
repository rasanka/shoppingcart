<?php
	ob_start();
	include_once ("config/config.php");	
	//require_once("user.class.php");
	
	//$userid = $_SESSION['ses_user_id'];
	
	//$userObj = new User();
	
	//$result = "";
	//$result = $userObj -> logoutLogin($userid);
	
	//if($result){
		session_start();
		session_destroy();
		unset($_SESSION['ses_name']);
		unset($_SESSION['ses_user_name']);
		unset($_SESSION['ses_user_id']);
		unset($_SESSION['ses_user_level']);
		header("Location:index.php");
		die();
	//}
	ob_end_flush();
?>

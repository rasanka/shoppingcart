<?php
	ob_start();
	include_once ("config/config.php");	
	//require_once("user.class.php");
	
	$userId = $_SESSION['sitid'];
	//$obj = new User();
	
	//$result = "";
	//$result = $obj -> logoutMember($memId);

	//if($result){
	session_start();
	session_destroy();
	
	unset($_SESSION['situser']);
	unset($_SESSION['sitid']);
	unset($_SESSION['sitcart']);
	unset($_SESSION['sitorder']);
	unset($_SESSION['sitemail']);
	
	header("Location:index.php");
	die();
	//}else{
	//	header("Location:".$SERVER_URL."index.php");
	//	die();
	//}
	ob_end_flush();
?>

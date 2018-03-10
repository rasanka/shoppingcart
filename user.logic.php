<?php
require_once ("config/config.php");
require_once ("user.class.php");
require_once ("mail_logic.class.php");
require_once ("logger.class.php");

$m_chk = $_GET['check'];

$userObj = new User();
$mailObj = new MailLogic();
$logger = new Logger();

if($m_chk == "register"){

	$email = $_POST['reg_email'];
	$f_name = $_POST['firstName'];
	$l_name = $_POST['lastName'];
	$contact = $_POST['contact'];
	$password = $_POST['reg_password'];
	$houseNo = $_POST['street_number'];
	$street = $_POST['route'];
	$city = $_POST['locality'];
	$region = $_POST['administrative_area_level_1'];
	$postal = $_POST['postal_code'];
	$country = $_POST['country'];
	
	$msg = "";
	$count = 0;
	$count = $userObj -> checkEmail($email);
	$msg_type = "";


	if($count > 0){
		$msg_type = "alert-warning";
		$msg = "User already exists with the email address ".$email;
	}else{
		$userId = $userObj -> saveUser($f_name,$l_name,$email,$contact,$password,$houseNo,$street,$city,$region,$postal,$country);

		//$logger -> logData('USER -'.$userId);

		if($userId <> 'ERROR') {

			require_once("activation_mail.tpl.php");

			$html = $activation_mail;
			$final_msg = $mailObj -> prepareHtmlMail($html);
			$subject = 'Activate your account with PhoneRepairParts.co.nz';
				
			if (mail($email, $subject, $final_msg['multipart'], $final_msg['headers'])) {
				$msg_type = "alert-success";
				$msg = "User created Successfully! <br/> Please activate your account by clicking on the link sent to your registered email address";
			} else {
				$msg_type = "alert-warning";
				$msg = "User created Successfully! <br/> Activation mail delivery failed! Please contact PhoneRepairParts.co.nz";
			}				

		} else {
			$msg_type = "alert-warning";
			$msg = "Error occured during user registration. Please try again!";
		}
	}

	$html = "
	<div class='alert ".$msg_type."'>
		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>".$msg."</b>
	</div> ";
	echo $html;	
	
} 

if($m_chk == "change_pwd"){

	session_start();

	$userEmail = $_SESSION['sitemail'];
	$oldPassword = $_POST['old_password'];
	$newPassword = $_POST['new_password'];

	$result = array();
	$result = $userObj -> validateLogin($userEmail,$oldPassword);

	if(count($result) > 0){

		$userId = $_SESSION['sitid'];
		$result = $userObj -> updateUserPassword($userId, $newPassword);

		if($result) {
				$msg_type = "alert-success";
				$msg = "Password changed Successfully! <br/> Please login to the system using the new Password!";
		} else {
			$msg_type = "alert-warning";
			$msg = "Error occured during user registration. Please try again!";			
		}

	} else {
		$msg_type = "alert-warning";
		$msg = "Error occured. <br/> Old Password incorrect!";
	}

	$html = "
	<div class='alert ".$msg_type."'>
		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>".$msg."</b>
	</div> ";
	echo $html;		
}

if($m_chk == "recover"){

	$email = $_POST['reg_email'];
	
	$msg = "";
	$count = 0;
	$count = $userObj -> checkEmail($email);
	$msg_type = "";


	if($count > 0){

		$details = array();
		$details = $userObj -> getUserDetailsByEmail($email);
		
		require_once("forgot_pwd_mail.tpl.php");
		
		$html = $forgot_pwd_mail;
		$final_msg = $mailObj -> prepareHtmlMail($html);
		$subject = 'Forgot password for PhoneRepairParts.co.nz';
			
		if (mail($details['email'], $subject, $final_msg['multipart'], $final_msg['headers'])) {
			$msg_type = "alert-success";
			$msg = "Login details has been sent to the registered email address. Please check the email.";
		} else {
			$msg_type = "alert-warning";
			$msg = "Message delivery failed!";
		}	
	}else{
		$msg_type = "alert-warning";
		$msg = "There is no registered user with this Email Address!";
	}

	$html = "
	<div class='alert ".$msg_type."'>
		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>".$msg."</b>
	</div> ";
	echo $html;		
}

?>

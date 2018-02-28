<?php 
require_once ("config/config.php");
require_once ("mail_logic.class.php");
require_once ("member.class.php");
require_once ("visitor.class.php");
require_once ("common.class.php");

$obj   = new Member();
$objV   = new Visitor();
$objM  = new MailLogic();
$objCF = new Common_Functions();
	
$action = $_GET['chksql'];

if($action == "bank_payment"){

	$id = $_GET['id'];
	$type = $_GET['type'];
	
	$details = array();		
	$amount = 0;	
	if($type == "MEMBER"){
		$details = $obj -> getMemberDetailsById($id);
	}else{
		$details = $objV -> getVisitorRequestById($id);
	}		
	$amount = $details["amount"];	
	$account = array();	
	$account = $objCF -> getBankAccount();
		
	if($details['email'] != ""){
		
		require_once("bank_payment_mail.tpl.php");
		
		$html = $bank_payment_mail;
		$final_msg = $objM -> prepareHtmlMail($html);
		$subject = 'eDoctor Bank Account Details';
		
		$check = "";
		$check = $objCF -> checkEmailLog($id);
		
		if($check == "YES")	{
			echo "Email Already Sent!";
		}else{
			if (mail($details['email'], $subject, $final_msg['multipart'], $final_msg['headers'])) {
				$result = $objCF -> updateEmailLog($id);
				echo "Email Successfully Sent!";
			} else {
				echo "Message delivery failed!";
			}	
		}
	}else{
		echo "Invalid Email Address!";
	}
}

if($action == "activation"){

	$id = $_GET['id'];
	
	$details = array();
	$details =  $obj -> getMemberDetailsById($id); 
	
	if($details['email'] != ""){
		
		require_once("activation_mail.tpl.php");
		
		$html = $activation_mail;
		$final_msg = $objM -> prepareHtmlMail($html);
		$subject = 'Activate your account with eDoctor.lk';
			
		if (mail($details['email'], $subject, $final_msg['multipart'], $final_msg['headers'])) {
			echo("Activation Email Sent");
		} else {
			echo("Message delivery failed!");
		}	
	}else{
		echo "Invalid Email Address!";
	}
}

if($action == "forgot_password"){

	$user = $_GET['user'];
	$email = $_GET['email'];
	
	$details = array();
	$details =  $obj -> getMemberDetailsByUsernameOrEmail($user, $email); 
	
	if($details['email'] != ""){
		
		require_once("forgot_pwd_mail.tpl.php");
		
		$html = $forgot_pwd_mail;
		$final_msg = $objM -> prepareHtmlMail($html);
		$subject = 'Forgot password for eDoctor.lk';
			
		if (mail($details['email'], $subject, $final_msg['multipart'], $final_msg['headers'])) {
			echo("Please Check the Email for Login Details!");
		} else {
			echo("Message delivery failed!");
		}	
	}else{
		echo "Invalid Username or Email Address!";
	}
}

if($action == "contact_us"){
	
	$name 	 = $_GET['name'];
	$email 	 = $_GET['email'];
	$subject = $_GET['subject'];
	$message = $_GET['message'];
	
	$result = "";
	$result = $objCF -> saveContactUsInquiry($name,$email,$subject,$message);
	
	if($result){
	
		require_once("contact_us_mail.tpl.php");
		
		$html = $contact_us_mail;
		
		$final_msg = $objM -> prepareHtmlMail($html);
		$subject = 'Thank You for Contacting eDoctor.lk';
			
		if (mail($email, $subject, $final_msg['multipart'], $final_msg['headers'])) {
			echo("Thank you for your response. We will be in touch with you within 24 hours.");
			
			require_once("inquiry_mail.tpl.php");
			
			$inq_html = $inquiry_mail;
			
			$final_msg = $objM -> prepareHtmlMail($inq_html);
			$subject = 'Inquiry about eDoctor.lk';
				
			mail("inquiry@edoctor.lk", $subject, $final_msg['multipart'], $final_msg['headers']);			
			
		} else {
			echo("Message delivery failed!");
		}	
	}
}

?>

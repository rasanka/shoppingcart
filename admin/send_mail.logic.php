<?php 
require_once ("config/config.php");
require_once ("mail_logic.class.php");
require_once ("admin_member.class.php");
require_once ("common.class.php");

$obj   = new Member();
$objM  = new MailLogic();
$objCF = new Common_Functions();
	
$action = $_GET['chksql'];

if($action == "newsletter"){
	
	$newsletterID = $_GET['id'];
	$subject = $_GET['subject'];
	
	$html = "";
	require_once("newsletter_mail.tpl.php");
	$html = $newsletter_mail;
	$sent_ok = "";
	$sent_err = "";	
	
	$noOfEmailsPerRound = 200;
	$rounds = $objCF -> getNewsletterRounds($noOfEmailsPerRound);
	
	/* TEST ----------------------------------------------
	$j = 0;
	$userCount = 0;
	while($j < 1){
		$senderEmail = "";
		$senderEmail = "newsletter".($j+1)."@edoctor.lk";
		
		$final_msg = $objM -> prepareNewsletterMail($html,$senderEmail);
		$users = array();	
		$users = $objCF -> getNewsletterUsers($userCount,$noOfEmailsPerRound);		
		$i = 0;
		
		if(mail('rasanka2006@gmail.com', $subject, $final_msg['multipart'], $final_msg['headers'])){
			$sent_ok .= "rasanka2006@gmail.com";
		}else{
			$sent_err .= "rasanka2006@gmail.com";
		}			
		$userCount += $noOfEmailsPerRound;
		$j +=1;
	}	
	------------------------------------------------------ */
	
	$j = 0;
	$userCount = 0;
	while($j < $rounds){
		$senderEmail = "";
		$senderEmail = "newsletter".($j+1)."@edoctor.lk";
		$final_msg = $objM -> prepareNewsletterMail($html,$senderEmail);
		$users = array();	
		$users = $objCF -> getNewsletterUsers($userCount,$noOfEmailsPerRound);		
		$i = 0;
		while ($i < count($users)) {
			if(mail($users[$i][0], $subject, $final_msg['multipart'], $final_msg['headers'])){
				$sent_ok .= $users[$i][0].",";
			}else{
				$sent_err .= $users[$i][0].",";
			}		
			$i +=1;
		}		
		$userCount += $noOfEmailsPerRound;
		$j +=1;
	}
		
	echo $sent_ok."#".$sent_err;
}

if($action == "approve_payment"){

	$id = $_GET['id'];
	
	$details = array();		
	$html = "";
	if(strpos($id,"V") === false){
		$details = $obj -> getMemberDetailsById($id);
		require_once("approve_payment_member_mail.tpl.php");
		$html = $approve_payment_member_mail;
	}else{
		$details = $obj -> getVisitorRequestDetailsById($id);
		require_once("approve_payment_visitor_mail.tpl.php");
		$html = $approve_payment_visitor_mail;
	}			
		
	if($details['email'] != ""){
		
		$final_msg = $objM -> prepareHtmlMail($html);
		$subject = 'eDoctor Payment Successfull.';
		
		if (mail($details['email'], $subject, $final_msg['multipart'], $final_msg['headers'])) {
			
			if(strpos($id,"V") === true){ // VISITOR
				require_once("doctor_notification_mail.tpl.php");
				$html = $doctor_notification_mail;
				$final_msg = $objM -> prepareHtmlMail($html);
				$subject = 'Pending Request to be Replied.';
				$activeEmail = $obj -> getActiveDoctorEmail();
				
				if(mail($activeEmail, $subject, $final_msg['multipart'], $final_msg['headers'])){
					echo "Email Successfully Sent!";
				}else{
					echo "Doctor Notification failed!";
				}
				
			}else{
				echo "Email Successfully Sent!";
			}
		} else {
			echo "Message delivery failed!";
		}	
	}else{
		echo "Invalid Email Address!";
	}
}

if($action == "generate_payment"){

	$id = $_GET['id'];
		
	$details = array();		
	$html = "";
	$package = "";
	if(strpos($id,"V") === false){
		$details = $obj -> getMemberDetailsById($id);
		$package = $details['package'];
	}else{
		$details = $obj -> getVisitorRequestDetailsById($id);
		$package = "VISITOR";
	}		
		
	require_once("pending_payment_mail.tpl.php");
	$html = $pending_payment_mail;
		
	if($details['email'] != ""){
		
		$final_msg = $objM -> prepareHtmlMail($html);
		$subject = 'Payment to eDoctor.lk.';
				
		if (mail($details['email'], $subject, $final_msg['multipart'], $final_msg['headers'])) {			
			echo "Email Successfully Sent!";
		} else {
			echo "Message delivery failed!";
		}	
	}else{
		echo "Invalid Email Address!";
	}
}

if($action == "update_exp_date"){

	$id = $_GET['id'];
		
	$details = array();		
	$html = "";
	$package = "";
	$details = $obj -> getMemberDetailsById($id);
	$package = $details['package'];		
		
	require_once("account_expire_mail.tpl.php");
	$html = $account_expire_mail;
		
	if($details['email'] != ""){
		
		$final_msg = $objM -> prepareHtmlMail($html);
		$subject = 'eDoctor.lk Account Expired.';
				
		if (mail($details['email'], $subject, $final_msg['multipart'], $final_msg['headers'])) {			
			echo "Email Successfully Sent!";
		} else {
			echo "Message delivery failed!";
		}	
	}else{
		echo "Invalid Email Address!";
	}
}

if($action == "notify_exp_date"){

	$id = $_GET['id'];
		
	$details = array();		
	$html = "";
	$package = "";
	$details = $obj -> getMemberDetailsById($id);
	$package = $details['package'];		
		
	require_once("notify_expire_mail.tpl.php");
	$html = $notify_expire_mail;
		
	if($details['email'] != ""){
		
		$final_msg = $objM -> prepareHtmlMail($html);
		$subject = 'eDoctor.lk Account about to be Expired.';
				
		if (mail($details['email'], $subject, $final_msg['multipart'], $final_msg['headers'])) {			
			echo "Email Successfully Sent!";
		} else {
			echo "Message delivery failed!";
		}	
	}else{
		echo "Invalid Email Address!";
	}
}
?>

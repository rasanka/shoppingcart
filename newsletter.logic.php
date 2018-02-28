<?php
require_once ("newsletter.class.php");

$m_chk = $_GET['check'];

$newsLetterObj = new NewsLetter();

if($m_chk == "subscribe"){

	$email = $_POST['subscribe_email'];
		
	$msg = "";
	$msg_type = "";

	$result = $newsLetterObj -> saveSubscribeEmail($email);
	
	if($result) {
		$msg_type = "alert-success";
		$msg = "Email added Successfully!";
	} else {
		$msg_type = "alert-warning";
		$msg = "Email already exsist!";
	}
	
	$html = "
	<div class='alert ".$msg_type."'>
		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>".$msg."</b>
	</div> ";
	echo $html;	
	
}

?>

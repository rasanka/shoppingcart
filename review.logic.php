<?php
require_once ("config/config.php");
require_once ("review.class.php");

$m_chk = $_GET['check'];

$reviewObj = new Review();

if($m_chk == "saveReview"){

    $prod_id = $_POST['hid_prod_id'];
	$review = $_POST['review_msg'];
	$name = $_POST['reviewer_name'];
	$email = $_POST['reviewer_email'];
	$rating = $_POST['hid_ratings'];

	$reviewId = 0;
	$reviewId = $reviewObj -> saveReview($prod_id,$rating,$review,$name,$email);
		
	if($reviewId > 0) {
		$msg_type = "alert-success";
		$msg = "Review saved Successfully!";
	} else {
		$msg_type = "alert-warning";
		$msg = "Error occured. Please try again!";
	}

	$html = "
	<div class='alert ".$msg_type."'>
		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>".$msg."</b>
	</div> ";
	echo $html;	
	
}


?>

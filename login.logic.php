<?php
	include_once ("config/config.php");	
	require_once("user.class.php");
	require_once("cart.class.php");
	require_once("logger.class.php");
	
	$obj = new User();
	$cartObj = new Cart();
	$logObj = new Logger();
	
	if (isset($_POST['validate'])) {

		$val_name = '';
		$val_id = '';
		$val_email = '';
	
		$username  = $_POST['userEmail'];
		$password  = $_POST['userPassword'];	

		$result = array();
		$result = $obj -> validateLogin($username,$password);
		
		if(count($result) > 0){
		
			$val_name = $result[0][0];
			$val_id = $result[0][1];
			$val_email = $result[0][2];

			//$logObj -> logData('EMAIL -'.$val_email);

			session_destroy();
			session_start();

			$_SESSION['situser'] = strtoupper($val_name);
			$_SESSION['sitid'] = $val_id;
			$_SESSION['sitemail'] = $val_email;

			//$logObj -> logData('SES EMAIL -'.$_SESSION['sitemail']);

			$cart_array = $cartObj -> loadCartByUserId($val_id);
			if(count($cart_array) > 0){
				$_SESSION['sitcart'] = $cart_array['cart_id'];
			}
			echo "OK";

		}else{
			$inactiveCnt = $obj -> isInactiveLogin($username,$password);
			if($inactiveCnt > 0) {
				echo "
					<div class='alert alert-warning'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Inactive Account. <br/> Please active the account using the link emailed to your registered email address.</b>
					</div>				
				";
			} else {
				echo "
					<div class='alert alert-warning'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Invalid Login. <br/> Please check the User name and Password.</b>
					</div>				
				";
			}
		}
		
	}
?>


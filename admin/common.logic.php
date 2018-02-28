<?php
require_once ("config/config.php");
require_once ("common.class.php");
	
$m_chksql = $_GET['chksql'];

$objCF = new Common_Functions();

if($m_chksql == "loadNewMenu"){
	$level = $_SESSION["ses_user_level"];
	$menu = "";
	$menu =  $objCF -> loadNewMenu($level); 
	echo $menu;			
}

if($m_chksql == "loadEmails"){
	
	$frm_date = $_GET['from'];
	$to_date = $_GET['to'];
	
	$data = array();
	
	$data = $objCF -> getAllNewsletterUsersByDate($frm_date,$to_date);
	
	$i = 0;
	$email = "";
	$emails = "<br>From - ".$frm_date." To - ".$to_date."<br><br>";
	$emails .= "<table class='body' width='100%'>";
	while ($i < count($data)) {	
		$email = $data[$i][0];
		$emails .= "<tr>
					<td>".$email.",</td>
				    </tr>";		
						
		$i +=1;
	}
	$emails .= "</table>";
	echo $emails;	
}
?>

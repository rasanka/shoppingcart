<?php
require_once ("config/config.php");
require_once ("common.class.php");
//require_once ("pagination.class.php");
	
$m_chksql = $_GET['chksql'];

$objCF = new Common_Functions();
//$objP = new Pagination();

/*
if($m_chksql == "setLanguage"){
	$lang = "";
	$lang = $_GET['lang'];
	
	//session_destroy();
	//session_start();
	$_SESSION['eDocLang'] = $lang;	
	echo "OK";
}

if($m_chksql == "newsletterSignup"){	
		
	$email = $_GET["email"];	
	$result = "";
	$result = $objCF -> newsletterSignup($email);

	echo $result;	
}

if($m_chksql == "loadArticles"){	

	$limit = $_GET['limit'];
	$item_details = array();	
	$item_details = $objCF -> getAllArticles($limit,$NOOFRECORDSPERPAGE);  
	
	if(count($item_details) > 1){
	
		$m_out = $m_out."<table id='gradient-style' width='100%' border='0' cellspacing='0' cellpadding='0' class='body'> ";
		
		$num = 0;
		$color = "";
		$rowCount = 1;
		$i = 0;
		
		while($i < (count($item_details)/5)){
		
			$encId = "";
			$encId = base64_encode($item_details['article_id'.$rowCount]);								

			$m_out = $m_out."<tr height='20' onClick=goToArticle('".$encId."');>   
								<td width='85%'><li>".$item_details['subject'.$rowCount]."</li><br></td> 
								<td width='15%' align='right'>".$item_details['date'.$rowCount]."<br></td>
							</tr>  ";	
				
			$rowCount += 1;		
			$i += 1;			
		}
				
		$tot_count = 0;	
		$tot_count = $objCF -> getAllArticlesCount(); 
		$offset = $NOOFRECORDSPERPAGE;
		
		$objP -> loadPagination($tot_count,$limit,$offset,'loadArticles');
		$m_out .= "</table><hr>";
		$m_out .= "<table width='100%' border='0' class='body'>
				   	<tr>
						<td align='center'>".$objP -> anchors ."</td>
 					</tr>
				   	<tr>
						<td>".$objP -> total ."</td>
 					</tr>					
				   </table>"; 						
											
	} else {
		$m_out = $m_out."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='body'> ".
				 " <tr>  ".
				 "	<td>&nbsp;</td> ".
				 " </tr> ".		
				 " <tr height='20'>  ".
				 "	<td align='center'>No Records Found!</td> ".
				 " </tr> ".
				 " <tr>  ".
				 "	<td>&nbsp;</td> ".
				 " </tr> ".				 
				 "</table>";
	}
	echo $m_out;		
}


if($m_chksql == "loadPackageDetails"){	

	$pkg_details = array();	
	$pkg_details = $objCF -> getPackageDescriptions();  
	
	if(count($pkg_details) > 1){
	
		$m_out = $m_out."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='body'> 
							<tr>   
								<td width='5%'>&nbsp;</td> 
								<td width='90%'>&nbsp;</td> 
								<td width='5%'>&nbsp;</td> 
							</tr>";
		
		$num = 0;
		$color = "";
		$rowCount = 1;
		$i = 0;
		
		while($i < (count($pkg_details)/2)){			

			$m_out = $m_out."<tr height='20'>   
								<td>&nbsp;</td> 
								<td valign='top'>".$pkg_details['description'.$rowCount]."</td> 
								<td>&nbsp;</td> 
							</tr>
							<tr>   
								<td>&nbsp;</td> 
								<td>&nbsp;</td> 
								<td>&nbsp;</td> 
							</tr>";	
				
			$rowCount += 1;		
			$i += 1;			
		}
				
		$m_out = $m_out."</table> <br>";		
		
		$pkg_summary = array();	
		$pkg_summary = $objCF -> getPackagesSummary();  
		
		$m_out = $m_out."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='body'>
						 <tr>
						 	<td width='5%'>&nbsp;</td>
							<td width='90%'> 
								<table width='100%' border='1' cellspacing='0' cellpadding='0' class='body'> 
									<tr class='heading'>   
										<td width='25%'>Package Type</td> 
										<td width='25%' align='center'>Number of Advice</td> 
										<td width='25%' align='center'>Time Period [DAYS]</td> 
										<td width='25%'>Amount LKR</td>
									</tr>";
			
		$num = 0;
		$color = "";
		$rowCount = 1;
		$i = 0;
			
		while($i < (count($pkg_summary)/4)){	
			
			$attempts = "";
			if($pkg_summary['attempts'.$rowCount] >= 50){
				$attempts = "Unlimited";
			}else{
				$attempts = $pkg_summary['attempts'.$rowCount];
			}	
			
			$pkg_amount = "";
			if($pkg_summary['amount'.$rowCount] == "0.00"){
				$pkg_amount = "Free";
			}else{
				$pkg_amount = $pkg_summary['amount'.$rowCount];
			}	
	
			$m_out = $m_out."<tr height='20'>   
								<td>".$pkg_summary['package'.$rowCount]."</td> 
								<td align='center'>".$attempts."</td> 
								<td align='center'>".$pkg_summary['time_period'.$rowCount]."</td> 
								<td>".$pkg_amount."</td> 
							</tr>";	
				
			$rowCount += 1;		
			$i += 1;			
		}
					
		$m_out = $m_out."</table></td>
						<td width='5%'>&nbsp;</td>
						</tr></table><br>";								
										
	} else {
		$m_out = $m_out."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='body'> ".
				 " <tr>  ".
				 "	<td>&nbsp;</td> ".
				 " </tr> ".		
				 " <tr height='20'>  ".
				 "	<td align='center'>No Records Found!</td> ".
				 " </tr> ".
				 " <tr>  ".
				 "	<td>&nbsp;</td> ".
				 " </tr> ".				 
				 "</table>";
	}
	echo $m_out;		
}
*/
?>

<?php
require_once("db_manager.class.php");

class Common_Functions extends DB_Manager{

	function loadNewMenu($level){
		$menu = "";
		
		if($level == "ADMIN"){
			$menu = " <ul id='verticalmenu' class='glossymenu'> ".
					"	<li><a href='home.php' ><img src='images/home.jpg' width='110' height='40' border='0'></a></li> ".
					"	<li><a href='#'>Payments</a> ".
					"		<ul> ".
					"		<li><a href='approve_payment.php'>Approve Payment</a></li> ".
					"		</ul> ".
					"	</li> ".												
					"	<li><a href='#' >Reports</a> ".
					// "		<ul> ".
					// "		<li><a href='members_report.php'>Users Report</a></li> ".
					//"		<li><a href='visitors_report.php'>Visitors Report</a></li> ".
					//"		<li><a href='email_report.php'>Email Report</a></li> ".
					// "		</ul> ".
					"	</li> ".	
					// "	<li><a href='#'>Articles</a> ".
					// "		<ul> ".
					// "		<li><a href='add_article.php'>Add New Article</a></li> ".
					// "		<li><a href='view_articles.php'>View Article's</a></li> ".
					// "		</ul> ".
					// "	</li> ".													
					"	<li><a href='#'>Maintainence</a> ".
					"		<ul> ".
					"		<li><a href='category.php'>Add | Edit Category</a></li> ".
					"		<li><a href='brand.php'>Add | Edit Brand</a></li> ".
					//"		<li><a href='supplier.php'>Add | Edit Supplier</a></li> ".
					"		<li><a href='product.php'>Add Product</a></li> ".
					"		<li><a href='item.php'>Add Item</a></li> ".
					"		<li><a href='search_product.php'>Search Product</a></li> ".
					//"		<li><a href='account.php'>Add | Edit Bank Account</a></li> ".
					"		</ul> ".
					"	</li> ".
					"	<li><a href='#'><img src='images/logout.jpg' width='110' height='40' border='0'></a> ".
					"		<ul> ".
					"		<li><a href='logout.php'>Logout</a></li> ".
					"		</ul> ".
					"	</li> ".								
					"	</ul> <br>";
					//" <div id='noti_Container'>Members<div class='noti_bubble'><div id='members_bubble'>0</div></div></div> <br>".
					//" <div id='noti_Container'>Visitors<div class='noti_bubble'><div id='visitors_bubble'>0</div></div></div> <br>".
					//" <div id='noti_Container'>Payments<div class='noti_bubble'><div id='payments_bubble'>0</div></div></div> ";
		}

		return $menu;
	
	}	
	
	function getNewsletterRounds($batch){
		$query = "SELECT ceil(COUNT(DISTINCT e.email)/".$batch.") FROM (
					SELECT a.email AS email FROM tbl_inquiry a
					UNION
					SELECT b.email AS email FROM tbl_members b
					UNION
					SELECT c.email AS email FROM tbl_visitors c
					UNION
					SELECT d.email AS email FROM tbl_newsletter_signup d) e";
					
		$result = $this -> executeQuery($query);			 	
		return $result[0][0];						
	}
	
	function getAllNewsletterUsers(){
		
		$query = "  SELECT DISTINCT e.email FROM (
					SELECT a.email AS email FROM tbl_inquiry a
					UNION
					SELECT b.email AS email FROM tbl_members b
					UNION
					SELECT c.email AS email FROM tbl_visitors c
					UNION
					SELECT d.email AS email FROM tbl_newsletter_signup d) e
					WHERE email != ''
					ORDER BY email; ";
									
		$result = "";
		$result = $this -> executeQuery($query);	
		
		return $result;
	}
	
	function getAllNewsletterUsersByDate($from,$to){
		
		$query = "  SELECT DISTINCT e.email FROM (
					SELECT a.email AS email FROM tbl_inquiry a 
					WHERE DATE_FORMAT(a.inq_date,'%Y-%m-%d') > '".$this ->dateconvert($from,1)."' AND DATE_FORMAT(a.inq_date,'%Y-%m-%d')  < '".$this ->dateconvert($to,1)."'
					UNION
					SELECT b.email AS email FROM tbl_members b
					WHERE DATE_FORMAT(b.reg_date,'%Y-%m-%d') > '".$this ->dateconvert($from,1)."' AND DATE_FORMAT(b.reg_date,'%Y-%m-%d')  < '".$this ->dateconvert($to,1)."'
					UNION
					SELECT c.email AS email FROM tbl_visitors c
					WHERE DATE_FORMAT(c.consult_date,'%Y-%m-%d') > '".$this ->dateconvert($from,1)."' AND DATE_FORMAT(c.consult_date,'%Y-%m-%d')  < '".$this ->dateconvert($to,1)."'
					UNION
					SELECT d.email AS email FROM tbl_newsletter_signup d
					WHERE DATE_FORMAT(d.added_date,'%Y-%m-%d') > '".$this ->dateconvert($from,1)."' AND DATE_FORMAT(d.added_date,'%Y-%m-%d')  < '".$this ->dateconvert($to,1)."') e
					WHERE email != ''
					ORDER BY email; ";
							
		$result = "";
		$result = $this -> executeQuery($query);	
		
		return $result;
	}		
	
	function getNewsletterUsers($limit,$batch){
		
		$query = "  SELECT DISTINCT e.email FROM (
					SELECT a.email AS email FROM tbl_inquiry a
					UNION
					SELECT b.email AS email FROM tbl_members b
					UNION
					SELECT c.email AS email FROM tbl_visitors c
					UNION
					SELECT d.email AS email FROM tbl_newsletter_signup d) e
					WHERE email != ''
					ORDER BY email
					LIMIT ".$limit.",".$batch."; ";
									
		$result = "";
		$result = $this -> executeQuery($query);	
		
		return $result;
	}	
	
	function updatePayment($id,$type,$user){
		if(strpos($id,"V") === false){
			$query = " UPDATE tbl_members
					   SET  payment_reference = '".$user."',
							payment_status = 'SUCCESS',
							payment_type = '".$type."',
							payment_date = now(),
							active_email = 'ACTIVE'
					   WHERE member_id = '".$id."' ";
		}else{
			$query = " UPDATE tbl_visitors
					   SET  payment_reference = '".$user."',
							payment_status = 'SUCCESS',
							payment_type = '".$type."',
							payment_date = now()
					   WHERE visitor_id = '".$id."' ";		
		}	
		$result = $this -> executeUpdateQuery($query);
				
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';		
			
		return $msg;
	}	
		
	function dateconvert($date,$func){
		if ($func == 1){ //insert conversion
			list($month, $day, $year) = split('[/.-]', $date);
			$date = "$year-$month-$day";
			return $date;
		}if ($func == 2){ //output conversion
			list($year, $month, $day) = split('[-.]', $date);
			$date = "$month/$day/$year";
			return $date;
		}
	} 

	function logData($data){
		/////home/users/web/b2956/d5.ebeesbiz/public_html/edoctor/admin/logs/
		$log_path = "C:\\wamp\\www\\edoctor\\admin\\logs\\";
		$file_name = $log_path. date("Y_m_d").".txt";
		$data = $data." \r\n";
		$file = fopen($file_name, "a");
		fwrite($file, $data);
		fclose($file);
	}
	
	function curPageURL() {
		
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}	
}
?>

<?php
require_once ("config/config.php");
require_once ("brand.class.php");
//require_once ("common.class.php");
	
$m_chksql = $_GET['chksql'];

$brandObj   = new Brand();

if($m_chksql == "saveBrand"){	

	$name= $_GET['name'];
    $cat_id= $_GET['cat_id'];

	$msg = '';
	$msg = $brandObj -> saveBrand($name,$cat_id); 

	echo $msg;	
}

if($m_chksql == "updateBrand"){	

	$id = $_GET['id'];
	$name= $_GET['name'];
	$cat_id= $_GET['cat_id'];

	$msg = '';
	$msg = $brandObj -> updateBrand($id,$name,$cat_id); 

	echo $msg;	
}

if($m_chksql == "deleteBrand"){	

	$id = $_GET['id'];
	$level = $_SESSION["ses_user_level"];
	
	$msg = '';
	if($level == "ADMIN"){
		$msg = $brandObj -> deleteBrand($id); 
	}
	echo $msg;	
}

if($m_chksql == "loadBrandList"){	
	
	$returnStr = "";
	$selStr = "<select name='brands' id='brands' class='body' onChange=''><option value='-'> -- Please Select --</option>";
	$optStr = "";
	$details = array();
	$details = $brandObj -> getBrandList();  
		
	$i = 0;
	while ($i < count($details)) {
		$optStr = $optStr."<option value='".$details[$i][0]."'>".$details[$i][0]." - ".strtoupper($details[$i][2])." - ".$details[$i][1]."</option>";			
		$i +=1;
	}
	
	$returnStr = $selStr.$optStr."</select>";
	echo $returnStr;	

}

if($m_chksql == "loadBrandListByCategory"){	

	$cat_id = $_GET['cat_id'];
	
	$returnStr = "";
	$selStr = "<select name='brands' id='brands' class='body' onChange=''><option value='-'> -- Please Select --</option>";
	$optStr = "";
	$details = array();
	$details = $brandObj -> getBrandListByCategory($cat_id);  
		
	$i = 0;
	while ($i < count($details)) {
		$optStr = $optStr."<option value='".$details[$i][0]."'>".$details[$i][0]." - ".strtoupper($details[$i][2])." - ".$details[$i][1]."</option>";			
		$i +=1;
	}
	
	$returnStr = $selStr.$optStr."</select>";
	echo $returnStr;	

}

?>

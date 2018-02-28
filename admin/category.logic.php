<?php
require_once ("config/config.php");
require_once ("category.class.php");
//require_once ("common.class.php");
	
$m_chksql = $_GET['chksql'];

$categoryObj   = new Category();

if($m_chksql == "saveCategory"){	

	$name= $_GET['name'];

	$msg = '';
	$msg = $categoryObj -> saveCategory($name); 

	echo $msg;	
}

if($m_chksql == "updateCategory"){	

	$id = $_GET['id'];
	$name= $_GET['name'];
	
	$msg = '';
	$msg = $categoryObj -> updateCategory($id,$name); 

	echo $msg;	
}

if($m_chksql == "deleteCategory"){	

	$id = $_GET['id'];
	$level = $_SESSION["ses_user_level"];
	
	$msg = '';
	if($level == "ADMIN"){
		$msg = $categoryObj -> deleteCategory($id); 
	}
	echo $msg;	
}

if($m_chksql == "loadCategoryList"){	
	
	$returnStr = "";
	$selStr = "<select name='categories' id='categories' class='body' onChange=''><option value='-'> -- Please Select --</option>";
	$optStr = "";
	$details = array();
	$details = $categoryObj -> getCategoryList();  
		
	$i = 0;
	while ($i < count($details)) {
		$optStr = $optStr."<option value='".$details[$i][0]."'>".$details[$i][0]." - ".strtoupper($details[$i][1])."</option>";			
		$i +=1;
	}
	
	$returnStr = $selStr.$optStr."</select>";
	echo $returnStr;	

}

if($m_chksql == "loadCategoryListForProduct"){	
	
	$returnStr = "";
	$selStr = "<select name='categories' id='categories' class='body' onChange='loadBrandListByCategory();'><option value='-'> -- Please Select --</option>";
	$optStr = "";
	$details = array();
	$details = $categoryObj -> getCategoryList();  
		
	$i = 0;
	while ($i < count($details)) {
		$optStr = $optStr."<option value='".$details[$i][0]."'>".$details[$i][0]." - ".strtoupper($details[$i][1])."</option>";			
		$i +=1;
	}
	
	$returnStr = $selStr.$optStr."</select>";
	echo $returnStr;	

}

?>

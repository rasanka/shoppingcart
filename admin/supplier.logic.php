<?php
require_once ("config/config.php");
require_once ("supplier.class.php");
	
$m_chksql = $_GET['chksql'];

$supplierObj   = new Supplier();

if($m_chksql == "saveSupplier"){	

	$name= $_GET['name'];

	$msg = '';
	$msg = $supplierObj -> saveSupplier($name); 

	echo $msg;	
}

if($m_chksql == "updateSupplier"){	

	$id = $_GET['id'];
	$name= $_GET['name'];
	
	$msg = '';
	$msg = $supplierObj -> updateSupplier($id,$name); 

	echo $msg;	
}

if($m_chksql == "deleteSupplier"){	

	$id = $_GET['id'];
	$level = $_SESSION["ses_user_level"];
	
	$msg = '';
	if($level == "ADMIN"){
		$msg = $supplierObj -> deleteSupplier($id); 
	}
	echo $msg;	
}

if($m_chksql == "loadSupplierList"){	
	
	$returnStr = "";
	$selStr = "<select name='suppliers' id='suppliers' class='body' onChange=''><option value='-'> -- Please Select --</option>";
	$optStr = "";
	$details = array();
	$details = $supplierObj -> getSupplierList();  
		
	$i = 0;
	while ($i < count($details)) {
		$optStr = $optStr."<option value='".$details[$i][0]."'>".$details[$i][0]." - ".strtoupper($details[$i][1])."</option>";			
		$i +=1;
	}
	
	$returnStr = $selStr.$optStr."</select>";
	echo $returnStr;	

}

?>

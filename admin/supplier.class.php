<?php
require_once("db_manager.class.php");

class Supplier extends DB_Manager{
	
	function getSupplierList(){
		$query = " SELECT supplier_id, supplier_name FROM tbl_suppliers;  ";
				 
		$result = $this -> executeQuery($query);
			 		
		return $result;
	}	
			
	function saveSupplier($name){
	
		$query = " INSERT INTO tbl_suppliers (supplier_name)
				   VALUES('".$name."');  ";
			 
		$result = "";
		$result = $this -> executeInsertQuery($query);
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;
	}	
		
	function updateSupplier($id,$name){
	
		$query = "  UPDATE tbl_suppliers
					SET supplier_name = '".$name."'
					WHERE 
						supplier_id = ".$id.";  ";
			 
		$result = "";
		$result = $this -> executeUpdateQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}		
	
	
	function deleteSupplier($id){
	
		$query = "  DELETE FROM tbl_suppliers
					WHERE supplier_id = ".$id.";  ";
			 
		$result = "";
		$result = $this -> executeDeleteQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}
		
	
	function getSupplierDetailsById($id){
	
		$query = "  SELECT supplier_name FROM tbl_suppliers
					WHERE supplier_id = ".$id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		if(count($result) > 0){
			$details = array("name"=>$result[0][0]);
		
			return $details;
		}else{
			return "NO_DATA";
		}
	
	}	
			
}
?>

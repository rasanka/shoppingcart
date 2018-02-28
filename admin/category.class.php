<?php
require_once("db_manager.class.php");

class Category extends DB_Manager{
	
	function getCategoryList(){
		$query = " SELECT cat_id, cat_name FROM tbl_categories;  ";
				 
		$result = $this -> executeQuery($query);
			 		
		return $result;
	}	
			
	function saveCategory($name){
	
		$query = " INSERT INTO tbl_categories (cat_id,cat_name)
				   VALUES('".$this -> getUID('C')."','".$name."');  ";
			 
		$result = "";
		$result = $this -> executeInsertQuery($query);
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;
	}	
		
	function updateCategory($id,$name){
	
		$query = "  UPDATE tbl_categories
					SET cat_name = '".$name."'
					WHERE 
						cat_id = '".$id."';  ";
			 
		$result = "";
		$result = $this -> executeUpdateQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}		
	
	
	function deleteCategory($id){
	
		$query = "  DELETE FROM tbl_categories
					WHERE cat_id = '".$id."';  ";
			 
		$result = "";
		$result = $this -> executeDeleteQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}
		
	
	function getCategoryDetailsById($id){
	
		$query = "  SELECT cat_name FROM tbl_categories
					WHERE cat_id = '".$id."'; ";
				 
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

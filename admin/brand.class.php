<?php
require_once("db_manager.class.php");

class Brand extends DB_Manager{
	
	function getBrandList(){
		$query = " SELECT a.brand_id, a.brand_name, b.cat_name FROM tbl_brands a, tbl_categories b WHERE a.cat_id = b.cat_id ORDER BY brand_id;  ";
				 
		$result = $this -> executeQuery($query);
			 		
		return $result;
	}

	function getBrandListByCategory($cat_id){
		$query = " SELECT a.brand_id, a.brand_name, b.cat_name FROM tbl_brands a, tbl_categories b WHERE a.cat_id = b.cat_id AND a.cat_id = ".$cat_id." ORDER BY brand_id;  ";
				 
		$result = $this -> executeQuery($query);
			 		
		return $result;
	}		
			
	function saveBrand($name, $cat_id){
	
		$query = " INSERT INTO tbl_brands (brand_name, cat_id)
				   VALUES('".$name."', ".$cat_id.");  ";
			 
		$result = "";
		$result = $this -> executeInsertQuery($query);
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;
	}	
		
	function updateBrand($id,$name,$cat){
	
		$query = "  UPDATE tbl_brands
					SET brand_name = '".$name."',
                        cat_id = ".$cat."
					WHERE 
						brand_id = ".$id.";  ";
			 
		$result = "";
		$result = $this -> executeUpdateQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}		
	
	
	function deleteBrand($id){
	
		$query = "  DELETE FROM tbl_brands
					WHERE brand_id = ".$id.";  ";
			 
		$result = "";
		$result = $this -> executeDeleteQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}
		
	
	function getBrandDetailsById($id){
	
		$query = "  SELECT brand_name,cat_id FROM tbl_brands
					WHERE brand_id = ".$id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		if(count($result) > 0){
			$details = array("name"=>$result[0][0], "cat_id"=>$result[0][1]);
		
			return $details;
		}else{
			return "NO_DATA";
		}
	
	}	
			
}
?>

<?php
require_once("db_manager.class.php");

class Category extends DB_Manager {
	
	function loadCategoryByID($cat_id){
	
		$query = "  SELECT cat_name FROM tbl_categories
					WHERE cat_id = ".$cat_id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$details = array();
		
		if(count($result) > 0){
			$details = array("cat_name"=>$result[0][0]);	
		}
		return $details;
	}
	
	function loadBrandByID($brand_id){
	
		$query = "  SELECT brand_name FROM tbl_brands
					WHERE brand_id = ".$brand_id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$details = array();
		
		if(count($result) > 0){
			$details = array("brand_name"=>$result[0][0]);	
		}
		return $details;
	}

	function loadCategories(){
	
		$query = "  SELECT cat_id, cat_name
					FROM tbl_categories; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {		
				
			$details["cat_id".($i+1)] = $result[$i][0];
			$details["cat_name".($i+1)] = $result[$i][1];

			$i +=1;
		}
		
		return $details;
	
	}

	function loadBrandsByCatId($cat_id){
	
		$query = "  SELECT brand_id, brand_name
					FROM tbl_brands
					WHERE cat_id = ".$cat_id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {		
				
			$details["brand_id".($i+1)] = $result[$i][0];
			$details["brand_name".($i+1)] = $result[$i][1];

			$i +=1;
		}
		
		return $details;
	
	}	

	function getBrandNameByCatIdAndBrandId($cat_id, $brand_id){
	
		$query = "  SELECT brand_name
					FROM tbl_brands
					WHERE cat_id = ".$cat_id." AND brand_id = ".$brand_id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		if(count($result) > 0){
			$details = array("brand_name"=>$result[0][0]);
			return $details;
		}else{
			return "NO_DATA";
		}
	
	}		

}
?>
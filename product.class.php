<?php
require_once("db_manager.class.php");

class Product extends DB_Manager {


	function loadProductByID($prod_id){
	
		$query = "  SELECT prod_name,prod_cat,prod_brand,ref_id
					FROM tbl_products
					WHERE prod_id = ".$prod_id." and status = 'SHOW'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$details = array();
		
		if(count($result) > 0){
			$details = array("prod_name"=>$result[0][0],
				"prod_cat"=>$result[0][1],
				"prod_brand"=>$result[0][2],
				"ref_id"=>$result[0][3]);	
		}
		return $details;
	}


	function loadProductImagesByID($prod_id){
	
		$query = "  SELECT seq_id,image_name
					FROM tbl_product_images
					WHERE prod_id = ".$prod_id."
					ORDER BY seq_id; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {		
				
			$details["seq_id".($i+1)] = $result[$i][0];
			$details["image_name".($i+1)] = $result[$i][1];

			$i +=1;
		}
		
		return $details;
	
	}	

	function loadMainProductImage($prod_id){
	
		$query = "  SELECT image_name
					FROM tbl_product_images
					WHERE prod_id = ".$prod_id." AND seq_id = 1; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$details = array();
		if(count($result) > 0){
			$details = array("image_name"=>$result[0][0]);	
		}
		return $details;
	
	}		


	function loadProductsByCategory($cat_id){
	
		$query = "  SELECT prod_id,prod_name,prod_cat,prod_brand,ref_id
					FROM tbl_products
					WHERE prod_cat = ".$cat_id." and status = 'SHOW'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {		
				
			$details["prod_id".($i+1)] = $result[$i][0];
			$details["prod_name".($i+1)] = $result[$i][1];
			$details["prod_cat".($i+1)] = $result[$i][2];
			$details["prod_brand".($i+1)] = $result[$i][3];
			$details["ref_id".($i+1)] = $result[$i][4];		
			
			$i +=1;
		}
		
		return $details;
	
	}

	function searchProductsByKeyword($keyword){
	
		$query = "  SELECT prod_id,prod_name,prod_cat,prod_brand,ref_id 
					FROM (
						SELECT CONCAT(p.prod_name,', ',p.ref_id) AS keywords, p.*  
						FROM tbl_products p) a
					WHERE UPPER(a.keywords) 
					LIKE '%".strtoupper($keyword)."%' and status = 'SHOW'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {		
				
			$details["prod_id".($i+1)] = $result[$i][0];
			$details["prod_name".($i+1)] = $result[$i][1];
			$details["prod_cat".($i+1)] = $result[$i][2];
			$details["prod_brand".($i+1)] = $result[$i][3];
			$details["ref_id".($i+1)] = $result[$i][4];		

			$i +=1;
		}
		
		return $details;
	
	}	

	function loadLatestProducts(){
	
		$query = "  SELECT prod_id,prod_name,prod_cat,prod_brand,ref_id
					FROM tbl_products
					WHERE status = 'SHOW'
					ORDER BY created_date desc LIMIT 8; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {		
				
			$details["prod_id".($i+1)] = $result[$i][0];
			$details["prod_name".($i+1)] = $result[$i][1];
			$details["prod_cat".($i+1)] = $result[$i][2];
			$details["prod_brand".($i+1)] = $result[$i][3];
			$details["ref_id".($i+1)] = $result[$i][4];		

			$i +=1;
		}
		
		return $details;
	
	}


	function loadTopRatedProducts(){
	
		$query = "  SELECT prod_id,prod_name,prod_cat,prod_brand,ref_id
					FROM tbl_products
					WHERE status = 'SHOW'
					ORDER BY rating desc LIMIT 8; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {		
				
			$details["prod_id".($i+1)] = $result[$i][0];
			$details["prod_name".($i+1)] = $result[$i][1];
			$details["prod_cat".($i+1)] = $result[$i][2];
			$details["prod_brand".($i+1)] = $result[$i][3];
			$details["ref_id".($i+1)] = $result[$i][4];		

			$i +=1;
		}
		
		return $details;
	
	}

	function loadProductsByCategoryAndBrand($cat_id, $brand_id){
	
		$query = "  SELECT prod_id,prod_name,prod_cat,prod_brand,ref_id
					FROM tbl_products
					WHERE prod_cat = ".$cat_id." AND prod_brand = ".$brand_id." and status = 'SHOW'; ";
					
		$this -> logData($query);
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {		
				
			$details["prod_id".($i+1)] = $result[$i][0];
			$details["prod_name".($i+1)] = $result[$i][1];
			$details["prod_cat".($i+1)] = $result[$i][2];
			$details["prod_brand".($i+1)] = $result[$i][3];
			$details["ref_id".($i+1)] = $result[$i][4];				

			$i +=1;
		}
		
		return $details;
	
	}

}
?>
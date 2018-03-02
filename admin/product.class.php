<?php
require_once("db_manager.class.php");

class Product extends DB_Manager{

	function getProductId() {
		return $this -> getUID('P');
	}
	
	function getProductList(){
		$query = " SELECT prod_id, prod_name FROM tbl_products;  ";
			
		//$this -> logData($query);	 
		$result = $this -> executeQuery($query);
			 		
		return $result;
	}	
			
	function saveProduct($prod_id,$name,$cat_id,$brand_id,$ref_id,$status){
			
		$query = " INSERT INTO tbl_products (prod_id,prod_name,prod_cat,prod_brand,ref_id,status)
				   VALUES('".$prod_id."','".$name."','".$cat_id."', '".$brand_id."', '".$ref_id."','".$status."');  ";
			 
		//$this -> logData($query);

		$result = $this -> executeInsertQuery($query);
		if($result) {
			return 'SUCCESS';
		} else {
			return 'ERROR';			
		}
	}	

	function saveProductImage($prod_id,$seq_id,$name){
	
		$query = " INSERT INTO tbl_product_images (prod_id, seq_id, image_name)
				   VALUES('".$prod_id."', ".$seq_id.", '".$name."');  ";

		//$this -> logData($query);
			 
		$result = "";
		$result = $this -> executeInsertQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;
	}	
		
	function updateProduct($id,$name,$cat_id,$brand_id,$status){
	
		$query = "  UPDATE tbl_products
					SET prod_name = '".$name."',
						prod_cat = '".$cat_id."',
						prod_brand = '".$brand_id."',
						status = '".$status."'
					WHERE 
						prod_id = '".$id."';  ";
			 
		$result = "";
		$result = $this -> executeUpdateQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}		
	
	
	function deleteProduct($id){
	
		$query = "  DELETE FROM tbl_products
					WHERE prod_id = '".$id."';  ";
			 
		$result = "";
		$result = $this -> executeDeleteQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}

	function deleteProductImages($id){
	
		$query = "  DELETE FROM tbl_product_images
					WHERE prod_id = '".$id."';  ";
			 
		$result = "";
		$result = $this -> executeDeleteQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}			
	
	function getProductDetailsById($id){
	
		$query = "  SELECT prod_name,prod_cat,prod_brand,ref_id,status 
					FROM tbl_products
					WHERE prod_id = '".$id."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		if(count($result) > 0){
			$details = array("name"=>$result[0][0], 
			"cat_id"=>$result[0][1],
			"brand_id"=>$result[0][2],
			"ref_id"=>$result[0][3],
			"status"=>$result[0][4]);
		
			return $details;
		}else{
			return "NO_DATA";
		}	
	}

	function getProductImages($pid){
		$query = " SELECT image_name FROM tbl_product_images WHERE prod_id = '".$pid."' ORDER BY seq_id;  ";
				 
		$result = $this -> executeQuery($query);
			 		
		return $result;
	}			

	function searchProducts($name,$cat_id,$brand,$ref_id) {
		
		$query = "  SELECT prod_id, prod_name, ref_id, created_date
					FROM tbl_products
					WHERE prod_cat = '".$cat_id."' AND prod_brand = '".$brand."'
					AND UPPER(prod_name) like UPPER('%".$name."%') AND UPPER(ref_id) like UPPER('%".$ref_id."%')
					ORDER BY created_date; ";
									
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {
			$details["prod_id".($i+1)] = $result[$i][0];
			$details["prod_name".($i+1)] = $result[$i][1];
			$details["ref_id".($i+1)] = $result[$i][2];
			$details["created_date".($i+1)] = $result[$i][3];
			
			$i +=1;
		}
		return $details;
	}
	
}
?>

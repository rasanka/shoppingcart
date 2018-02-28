<?php
require_once("db_manager.class.php");

class Item extends DB_Manager{
	
	function getItemList(){
		$query = " SELECT item_id, item_name FROM tbl_items;  ";
			
		//$this -> logData($query);	 
		$result = $this -> executeQuery($query);
			 		
		return $result;
	}	
			
	function saveItem($name,$prod_id,$short_desc,$desc,$price,$stock,$ref_id,$keywords,$status,$rating,$badge){
	
		$query = " INSERT INTO tbl_items (item_name,short_desc,item_desc,item_prod,item_price,
											 item_stock,ref_id,item_keywords,status,rating,badge)
				   VALUES('".$name."','".$short_desc."','".$desc."', ".$prod_id.", ".$price.", ".$stock.", '".$ref_id."', '".$keywords."', '".$status."', ".$rating.", '".$badge."');  ";
			 
		$this -> logData($query);

		$id = 0;
		$id = $this -> executeInsertQueryReturnID($query);
					
		return $id;
	}	

	function saveItemImage($item_id,$seq_id,$name){
	
		$query = " INSERT INTO tbl_item_images (item_id, seq_id, image_name)
				   VALUES(".$item_id.", ".$seq_id.", '".$name."');  ";

		$this -> logData($query);
			 
		$result = "";
		$result = $this -> executeInsertQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;
	}	
		
	function updateProduct($id,$name,$cat_id,$brand_id,$short_desc,$desc,$price,$stock,$supplier,$keywords,$status,$rating,$badge){
	
		$query = "  UPDATE tbl_products
					SET prod_name = '".$name."',
						short_desc = '".$short_desc."',
						product_desc = '".$desc."',
						prod_cat = ".$cat_id.",
						prod_brand = ".$brand_id.",
						prod_price = ".$price.",
						prod_stock = ".$stock.",
						supplier_id = ".$supplier.",
						prod_keywords = '".$keywords."',
						status = '".$status."',
						rating = ".$rating.",
						badge = '".$badge."'
					WHERE 
						prod_id = ".$id.";  ";
			 
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
					WHERE prod_id = ".$id.";  ";
			 
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
					WHERE prod_id = ".$id.";  ";
			 
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
	
		$query = "  SELECT prod_name,product_desc,prod_cat,prod_brand,prod_price,prod_stock,ref_id,supplier_id,prod_keywords,status,short_desc,rating,badge 
					FROM tbl_products
					WHERE prod_id = ".$id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		if(count($result) > 0){
			$details = array("name"=>$result[0][0], 
			"desc"=>$result[0][1],
			"cat_id"=>$result[0][2],
			"brand_id"=>$result[0][3],
			"price"=>$result[0][4],
			"stock"=>$result[0][5],
			"ref_id"=>$result[0][6],
			"sup_id"=>$result[0][7],
			"keywords"=>$result[0][8],
			"status"=>$result[0][9],
			"short_desc"=>$result[0][10],
			"rating"=>$result[0][11],
			"badge"=>$result[0][12]);
		
			return $details;
		}else{
			return "NO_DATA";
		}	
	}

	function getProductImages($pid){
		$query = " SELECT image_name FROM tbl_product_images WHERE prod_id = ".$pid." ORDER BY seq_id;  ";
				 
		$result = $this -> executeQuery($query);
			 		
		return $result;
	}			

	function searchProducts($name,$cat_id,$brand,$ref_id) {
		
		$query = "  SELECT prod_id, prod_name, ref_id, created_date
					FROM tbl_products
					WHERE prod_cat = ".$cat_id." AND prod_brand = ".$brand."
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

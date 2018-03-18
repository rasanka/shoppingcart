<?php
require_once("db_manager.class.php");

class Item extends DB_Manager{

	function getItemId() {
		return $this -> getUID('I');
	}
	
	function getItemList(){
		$query = " SELECT item_id, item_name FROM tbl_items;  ";
			
		//$this -> logData($query);	 
		$result = $this -> executeQuery($query);
			 		
		return $result;
	}	
			
	function saveItem($itm_id,$name,$prod_id,$short_desc,$desc,$price,$discount_price,$stock,$ref_id,$delivery,$keywords,$status,$rating,$badge){
	
		if (empty($var)) {
			$discount_price = 0;
		}
		$query = " INSERT INTO tbl_items (item_id,item_name,short_desc,item_desc,item_prod,item_price,item_discount_price,
											 item_stock,ref_id,delivery,item_keywords,status,rating,badge)
				   VALUES('".$itm_id."','".$name."','".$short_desc."','".$desc."', '".$prod_id."', ".$price.", ".$discount_price.", ".$stock.", '".$ref_id."', ".$delivery.", '".$keywords."', '".$status."', ".$rating.", '".$badge."');  ";
			 
		//$this -> logData($query);

		$result = $this -> executeInsertQuery($query);

		if($result) {
			return 'SUCCESS';
		} else {
			return 'ERROR';			
		}

	}	

	function saveItemImage($item_id,$seq_id,$name){
	
		$query = " INSERT INTO tbl_item_images (item_id, seq_id, image_name)
				   VALUES('".$item_id."', ".$seq_id.", '".$name."');  ";

		//$this -> logData('saveItemImage QUERY -'.$query);
			 
		$result = "";
		$result = $this -> executeInsertQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;
	}	
		
	function updateItem($id,$name,$prod_id,$ref_id,$delivery,$short_desc,$desc,$price,$discount_price,$stock,$keywords,$status,$rating,$badge){
	
		$query = "  UPDATE tbl_items
					SET item_name = '".$name."',
						short_desc = '".$short_desc."',
						item_desc = '".$desc."',
						item_prod = '".$prod_id."',
						ref_id = '".$ref_id."',
						delivery = ".$delivery.",
						item_price = ".$price.",
						item_discount_price = ".$discount_price.",
						item_stock = ".$stock.",
						item_keywords = '".$keywords."',
						status = '".$status."',
						rating = ".$rating.",
						badge = '".$badge."'
					WHERE 
						item_id = '".$id."';  ";
			 
		$result = "";
		$result = $this -> executeUpdateQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}		
	
	
	function deleteItem($id){
	
		$query = "  DELETE FROM tbl_items
					WHERE item_id = '".$id."';  ";
			 
		$result = "";
		$result = $this -> executeDeleteQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}

	function deleteItemImages($id){
	
		$query = "  DELETE FROM tbl_item_images
					WHERE item_id = '".$id."';  ";
			 
		$result = "";
		$result = $this -> executeDeleteQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}			
	
	function getItemDetailsById($id){
	
		$query = "  SELECT item_name,item_desc,item_prod,item_price,item_discount_price,item_stock,ref_id,delivery,item_keywords,status,short_desc,rating,badge 
					FROM tbl_items
					WHERE item_id = '".$id."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		if(count($result) > 0){
			$details = array("name"=>$result[0][0], 
			"desc"=>$result[0][1],
			"item_prod"=>$result[0][2],
			"price"=>$result[0][3],
			"discount_price"=>$result[0][4],
			"stock"=>$result[0][5],
			"ref_id"=>$result[0][6],
			"delivery"=>$result[0][7],
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

	function getItemImages($pid){
		$query = " SELECT image_name FROM tbl_item_images WHERE item_id = '".$pid."' ORDER BY seq_id;  ";
				 
		$result = $this -> executeQuery($query);
			 		
		return $result;
	}			

	function searchItems($name,$prod_id,$ref_id) {
		
		$query = "  SELECT item_id, item_name, ref_id, created_date
					FROM tbl_items
					WHERE item_prod = '".$prod_id."'
					AND UPPER(item_name) like UPPER('%".$name."%') AND UPPER(ref_id) like UPPER('%".$ref_id."%')
					ORDER BY created_date; ";

		//$this -> logData($query);			
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {
			$details["item_id".($i+1)] = $result[$i][0];
			$details["item_name".($i+1)] = $result[$i][1];
			$details["ref_id".($i+1)] = $result[$i][2];
			$details["created_date".($i+1)] = $result[$i][3];
			
			$i +=1;
		}
		return $details;
	}
	
}
?>

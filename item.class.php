<?php
require_once("db_manager.class.php");

class Item extends DB_Manager {


	function loadItemByID($item_id){
	
		$query = "  SELECT item_name,item_desc,item_prod,item_price,item_stock,ref_id,item_keywords,short_desc,rating,badge
					FROM tbl_items
					WHERE item_id = ".$item_id." and status = 'SHOW'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$details = array();
		
		if(count($result) > 0){
			$details = array("item_name"=>$result[0][0],
				"item_desc"=>$result[0][1],
				"item_prod"=>$result[0][2],
				"item_price"=>$result[0][3],
				"item_stock"=>$result[0][4],
				"ref_id"=>$result[0][5],
				"item_keywords"=>$result[0][6],
				"short_desc"=>$result[0][7],
				"rating"=>$result[0][8],
				"badge"=>$result[0][9]);	
		}
		return $details;
	}


	function loadItemImagesByID($item_id){
	
		$query = "  SELECT seq_id,image_name
					FROM tbl_item_images
					WHERE item_id = ".$item_id."
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

	function loadMainItemImage($item_id){
	
		$query = "  SELECT image_name
					FROM tbl_item_images
					WHERE item_id = ".$item_id." AND seq_id = 1; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$details = array();
		if(count($result) > 0){
			$details = array("image_name"=>$result[0][0]);	
		}
		return $details;
	
	}		


	function loadItemsByProduct($prod_id){
	
		$query = "  SELECT item_id,item_name,item_desc,item_prod,item_price,item_stock,ref_id,item_keywords,short_desc,rating,badge
					FROM tbl_items
					WHERE item_prod = ".$prod_id." and status = 'SHOW'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {		
				
			$details["item_id".($i+1)] = $result[$i][0];
			$details["item_name".($i+1)] = $result[$i][1];
			$details["item_desc".($i+1)] = $result[$i][2];
			$details["item_prod".($i+1)] = $result[$i][3];
			$details["item_price".($i+1)] = $result[$i][4];
			$details["item_stock".($i+1)] = $result[$i][5];
			$details["ref_id".($i+1)] = $result[$i][6];		
			$details["item_keywords".($i+1)] = $result[$i][7];
			$details["short_desc".($i+1)] = $result[$i][8];
			$details["rating".($i+1)] = $result[$i][9];
			$details["badge".($i+1)] = $result[$i][10];

			$i +=1;
		}
		
		return $details;
	
	}

	function searchItemsByKeyword($keyword){
	
		$query = "  SELECT item_id,item_name,item_desc,item_prod,item_price, item_stock,ref_id,item_keywords,short_desc,rating,badge 
					FROM (
						SELECT CONCAT(p.item_name,', ',p.short_desc,', ',p.item_desc,', ',p.item_price,', ',p.ref_id,', ',p.item_keywords) AS keywords, p.*  
						FROM tbl_items p) a
					WHERE UPPER(a.keywords) 
					LIKE '%".strtoupper($keyword)."%' and status = 'SHOW'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {		
				
			$details["item_id".($i+1)] = $result[$i][0];
			$details["item_name".($i+1)] = $result[$i][1];
			$details["item_desc".($i+1)] = $result[$i][2];
			$details["item_prod".($i+1)] = $result[$i][3];
			$details["item_price".($i+1)] = $result[$i][4];
			$details["item_stock".($i+1)] = $result[$i][5];
			$details["ref_id".($i+1)] = $result[$i][6];		
			$details["item_keywords".($i+1)] = $result[$i][7];
			$details["short_desc".($i+1)] = $result[$i][8];
			$details["rating".($i+1)] = $result[$i][9];
			$details["badge".($i+1)] = $result[$i][10];

			$i +=1;
		}
		
		return $details;
	
	}	

	function loadLatestItems(){
	
		$query = "  SELECT item_id,item_name,item_desc,item_prod,item_price,item_stock,ref_id,item_keywords,short_desc,rating,badge 
					FROM tbl_items
					WHERE status = 'SHOW'
					ORDER BY created_date desc LIMIT 8; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {		
				
			$details["item_id".($i+1)] = $result[$i][0];
			$details["item_name".($i+1)] = $result[$i][1];
			$details["item_desc".($i+1)] = $result[$i][2];
			$details["item_prod".($i+1)] = $result[$i][3];
			$details["item_price".($i+1)] = $result[$i][4];
			$details["item_stock".($i+1)] = $result[$i][5];
			$details["ref_id".($i+1)] = $result[$i][6];		
			$details["item_keywords".($i+1)] = $result[$i][7];
			$details["short_desc".($i+1)] = $result[$i][8];
			$details["rating".($i+1)] = $result[$i][9];
			$details["badge".($i+1)] = $result[$i][10];

			$i +=1;
		}
		
		return $details;
	
	}


	function loadTopRatedItems(){
	
		$query = "  SELECT item_id,item_name,item_desc,item_prod,item_price, item_stock,ref_id,item_keywords,short_desc,rating,badge 
					FROM tbl_items
					WHERE status = 'SHOW'
					ORDER BY rating desc LIMIT 8; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {		
				
			$details["item_id".($i+1)] = $result[$i][0];
			$details["item_name".($i+1)] = $result[$i][1];
			$details["item_desc".($i+1)] = $result[$i][2];
			$details["item_prod".($i+1)] = $result[$i][3];
			$details["item_price".($i+1)] = $result[$i][4];
			$details["item_stock".($i+1)] = $result[$i][5];
			$details["ref_id".($i+1)] = $result[$i][6];		
			$details["item_keywords".($i+1)] = $result[$i][7];
			$details["short_desc".($i+1)] = $result[$i][8];
			$details["rating".($i+1)] = $result[$i][9];
			$details["badge".($i+1)] = $result[$i][10];

			$i +=1;
		}
		
		return $details;
	
	}

}
?>
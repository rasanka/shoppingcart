<?php
require_once("db_manager.class.php");

class Cart extends DB_Manager {
	
	function loadCartById($cart_id){
	
		$query = "  SELECT user_id, total_price, created_datetime, cart_status
					FROM tbl_cart
					WHERE cart_id = ".$cart_id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
	
		if (count($result) > 0) {		
			$details = array("user_id"=>$result[0][0], "total_price"=>$result[0][1], "created_datetime"=>$result[0][2], "cart_status"=>$result[0][3]);
		}
		
		return $details;
	
	}

	function loadCartItemsById($cart_id){
	
		$query = "  SELECT prod_id, qty, unit_price
					FROM tbl_cart_items
					WHERE cart_id = ".$cart_id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();

		while ($i < count($result)) {		
				
			$details["prod_id".($i+1)] = $result[$i][0];
            $details["qty".($i+1)] = $result[$i][1];
            $details["unit_price".($i+1)] = $result[$i][2];

			$i +=1;
		}
		
		return $details;
	
	}    

}
?>
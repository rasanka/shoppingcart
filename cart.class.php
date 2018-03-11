<?php
require_once("db_manager.class.php");

class Cart extends DB_Manager {

	function loadCartByUserId($user_id){
	
		$query = "  SELECT cart_id, total_price, created_datetime
					FROM tbl_cart
					WHERE user_id = '".$user_id."' and cart_status = 'INCOMPLETE'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
	
		if (count($result) > 0) {		
			$details = array("cart_id"=>$result[0][0], "total_price"=>$result[0][1], "created_datetime"=>$result[0][2]);
		}
		
		return $details;
	
	}
	
	function loadCartById($cart_id){
	
		$query = "  SELECT user_id, total_price, created_datetime, cart_status
					FROM tbl_cart
					WHERE cart_id = '".$cart_id."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
	
		if (count($result) > 0) {		
			$details = array("user_id"=>$result[0][0], "total_price"=>$result[0][1], "created_datetime"=>$result[0][2], "cart_status"=>$result[0][3]);
		}
		
		return $details;
	
	}

	function getCartQty($cart_id){
	
		$query = "  SELECT IFNULL(SUM(qty), 0) 
					FROM tbl_cart a, tbl_cart_items b 
					WHERE a.cart_id = b.cart_id 
					AND  b.cart_id = '".$cart_id."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
	
		if (count($result) > 0) {		
			$details = array("qty_count"=>$result[0][0]);
		}
		
		return $details;
	}    

	function getIncompleteCartQty($cart_id){
	
		$query = "  SELECT IFNULL(SUM(qty), 0) 
					FROM tbl_cart a, tbl_cart_items b 
					WHERE a.cart_id = b.cart_id 
					AND  b.cart_id = '".$cart_id."' AND cart_status = 'INCOMPLETE'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
	
		if (count($result) > 0) {		
			$details = array("qty_count"=>$result[0][0]);
		}
		
		return $details;
	}   	

 	function getCartTotal($cart_id){
	
		$query = "  SELECT total_price
					FROM tbl_cart
					WHERE cart_id = '".$cart_id."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
	
		if (count($result) > 0) {		
			$details = array("cart_total"=>$result[0][0]);
		}
		
		return $details;
	}     

	function loadCartItemsById($cart_id){
	
		$query = "  SELECT prod_id, qty, unit_price
					FROM tbl_cart_items
					WHERE cart_id = '".$cart_id."'; ";
				 
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

	function isCartExsist($cart_id){
	
		$query = "  SELECT count(*)
					FROM tbl_cart
					WHERE cart_id = '".$cart_id."' AND cart_status = 'INCOMPLETE'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);

		if(count($result) > 0){
			$details = array("cart_exsist"=>$result[0][0]);
		}
		
		return $details;
	
	}


	function isCartAvailable($user_id, $status){
	
		$query = "  SELECT count(*)
					FROM tbl_cart
					WHERE user_id = '".$user_id."' AND cart_status = '".$status."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);

		if(count($result) > 0){
			$details = array("cart_count"=>$result[0][0]);
		}
		
		return $details;
	
	}

	function isCartEmpty($cart_id){
	
		$query = "  SELECT count(*)
					FROM tbl_cart_items
					WHERE cart_id = '".$cart_id."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);

		if(count($result) > 0){
			$details = array("cart_empty"=>$result[0][0]);
		}
		
		return $details;
	
	}    

	function isItemInCart($cart_id, $prod_id){
	
		$query = "  SELECT count(*)
					FROM tbl_cart_items
					WHERE cart_id = '".$cart_id."' AND prod_id = '".$prod_id."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);

		if(count($result) > 0){
			$details = array("item_count"=>$result[0][0]);
		}
		
		return $details;
	
	}    

    function createCart($user_id, $prod_id, $qty, $unit_price) {

        $details = $this -> isCartAvailable($user_id, 'INCOMPLETE');
		if($details['item_count'] == 0) {

			$cart_id = $this -> getUID('C');
            $query = "  INSERT INTO tbl_cart (cart_id, user_id, total_price, ip_addr, cart_status, created_datetime) 
                        VALUES('".$cart_id."','".$user_id."',".floatval(intval($qty)*floatval($unit_price)).",'".$this -> getClientIP()."', 'INCOMPLETE', now()); ";

            //$result = "";
            $result = $this -> executeInsertQuery($query);

			if($result) {
				$query = "  INSERT INTO tbl_cart_items (cart_id, prod_id, qty, unit_price) 
							VALUES('".$cart_id."','".$prod_id."',".intval($qty).",".floatval($unit_price)."); ";
					
				$result = $this -> executeInsertQuery($query);
				return $cart_id;
			} else {
            	return "ERROR";
        	}
        } else {
            return "ERROR";
        }
    }	

    function updateCart($cart_id, $prod_id, $qty, $unit_price) {

        $query = "  UPDATE tbl_cart 
                    SET total_price = total_price + ".floatval(intval($qty)*floatval($unit_price))." 
                    WHERE cart_id = '".$cart_id."'; ";

        $result = "";
		$result = $this -> executeUpdateQuery($query);

        $details = $this -> isItemInCart($cart_id, $prod_id);
		if($details['item_count'] > 0) { // Item already in the Cart

            $query = "  UPDATE tbl_cart_items 
                        SET qty = qty + ".$qty."
                        WHERE cart_id = '".$cart_id."' AND prod_id = '".$prod_id."'; ";

            $result = $this -> executeUpdateQuery($query);                        

        } else { // Adding the new item to the cart

            $query = "  INSERT INTO tbl_cart_items (cart_id, prod_id, qty, unit_price) 
                        VALUES('".$cart_id."','".$prod_id."',".intval($qty).",".floatval($unit_price)."); ";
            
            $result = $this -> executeInsertQuery($query);
        }

        return $result;
    } 

    function updateCartStatus($cart_id, $status) {

        $query = "  UPDATE tbl_cart 
                    SET cart_status = '".$status."' 
                    WHERE cart_id = '".$cart_id."'; ";

        $result = "";
		$result = $this -> executeUpdateQuery($query);

        return $result;
    }	

    function updateCartQty($cart_id, $prod_id, $qty, $unit_price) {

        $query = "  UPDATE tbl_cart_items 
                    SET qty = ".$qty."
                    WHERE cart_id = '".$cart_id."' AND prod_id = '".$prod_id."'; ";

        $result = $this -> executeUpdateQuery($query);  

        $query = "  UPDATE tbl_cart 
                    SET total_price = (SELECT SUM(qty*unit_price) FROM tbl_cart_items WHERE cart_id = '".$cart_id."') 
                    WHERE cart_id = '".$cart_id."'; ";

        $result = "";
		$result = $this -> executeUpdateQuery($query);        

        return $result;
    } 

    function removeItemFromCart($cart_id, $prod_id) {

        $query = "  DELETE FROM tbl_cart_items 
                    WHERE cart_id = '".$cart_id."' AND prod_id = '".$prod_id."'; ";

        $result = $this -> executeDeleteQuery($query); 

        $details = $this -> isCartEmpty($cart_id);

        if($details['cart_empty'] == 0) { 
            $query = "  DELETE FROM tbl_cart 
                        WHERE cart_id = '".$cart_id."'; ";

            $result = "";
            $result = $this -> executeDeleteQuery($query);  
        } else {
            $query = "  UPDATE tbl_cart 
                        SET total_price = (SELECT SUM(qty*unit_price) FROM tbl_cart_items WHERE cart_id = '".$cart_id."') 
                        WHERE cart_id = '".$cart_id."'; ";

            $result = "";
            $result = $this -> executeUpdateQuery($query);  
        }

        return $result;
    }          

    function getClientIP() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }       

}
?>
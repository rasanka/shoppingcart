<?php
require_once("db_manager.class.php");

class Order extends DB_Manager {

	function loadOrderDetailsById($order_id){
	
		$query = "  SELECT cart_id, user_id, cart_total, tax_amount, order_total, billing_name,
                    billing_company, billing_email, billing_contact, billing_address, delivery_name,
                    delivery_company, delivery_email, delivery_contact, delivery_address, delivery_note,
                    payment_method, order_datetime, order_status
					FROM tbl_orders
					WHERE order_id = ".$order_id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
	
		if (count($result) > 0) {		
			$details = array(
                "cart_id"=>$result[0][0], 
                "user_id"=>$result[0][1], 
                "cart_total"=>$result[0][2], 
                "tax_amount"=>$result[0][3], 
                "order_total"=>$result[0][4], 
                "billing_name"=>$result[0][5], 
                "billing_company"=>$result[0][6], 
                "billing_email"=>$result[0][7], 
                "billing_contact"=>$result[0][8], 
                "billing_address"=>$result[0][9], 
                "delivery_name"=>$result[0][10], 
                "delivery_company"=>$result[0][11], 
                "delivery_email"=>$result[0][12], 
                "delivery_contact"=>$result[0][13],                                                 
                "delivery_address"=>$result[0][14],
                "delivery_note"=>$result[0][15], 
                "payment_method"=>$result[0][16], 
                "order_datetime"=>$result[0][17],                                                 
                "order_status"=>$result[0][18]);
		}
		
		return $details;
	
	} 

	function loadOrdersByUserId($user_id){
	
		$query = "  SELECT order_id, cart_id, cart_total, tax_amount, order_total, 
                    payment_method, order_datetime, order_status
					FROM tbl_orders
					WHERE user_id = ".$user_id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
	
        $details = array();
		if (count($result) > 0) {			
		
		    $i = 0;
		    while ($i < count($result)) {		
				
			    $details["order_id".($i+1)] = $result[$i][0];
                $details["cart_id".($i+1)] = $result[$i][1];
                $details["cart_total".($i+1)] = $result[$i][2];
                $details["tax_amount".($i+1)] = $result[$i][3];
                $details["order_total".($i+1)] = $result[$i][4];
                $details["payment_method".($i+1)] = $result[$i][5];
                $details["order_datetime".($i+1)] = $result[$i][6];
                $details["order_status".($i+1)] = $result[$i][7];

			    $i +=1;
		    }
		}
		
		return $details;
	
	}     

	function isSameOrder($order_id, $cart_id){
	
		$query = "  SELECT count(*)
					FROM tbl_orders
					WHERE order_id = ".$order_id." AND cart_id = ".$cart_id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);

		if(count($result) > 0){
			$details = array("same_order"=>$result[0][0]);
		}
		
		return $details;
	
	}       

    function createOrder($cart_id, $user_id, $cart_total, $tax, $order_total, $billing_name, $billing_company, $billing_email, $billing_contact, $billing_addr, $delivery_name, $delivery_company, $delivery_email, $delivery_contact, $delivery_addr, $delivery_note, $pay_method, $status) {

        $query = "  INSERT INTO tbl_orders (cart_id, user_id, cart_total, tax_amount, order_total, 
                    billing_name, billing_company, billing_email, billing_contact, billing_address, 
                    delivery_name, delivery_company, delivery_email, delivery_contact, delivery_address, delivery_note, 
                    payment_method, order_datetime, order_status) 
                    VALUES(".$cart_id.",".$user_id.",".$cart_total.",".$tax.",".$order_total.",'".
                    $billing_name."','".$billing_company."','".$billing_email."','".$billing_contact."','".
                    $billing_addr."','".$delivery_name."','".$delivery_company."','".$delivery_email."','".
                    $delivery_contact."','".$delivery_addr."','".$delivery_note."','".$pay_method."',now(),'".$status."'); ";

        $inserted_order_id = $this -> executeInsertQueryReturnID($query);

        return $inserted_order_id;

    }

    function updateOrderStatus($order_id, $status) {

        $query = "  UPDATE tbl_orders
                    SET order_status = '".$status."'
                    WHERE order_id = ".$order_id."; ";

        $result = $this -> executeUpdateQuery($query);
        return $result;
    }	

}
?>
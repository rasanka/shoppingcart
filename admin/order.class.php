<?php
require_once("db_manager.class.php");

class Order extends DB_Manager{

	function loadOrderDetailsById($order_id){
	
		$query = "  SELECT cart_id, user_id, cart_total, delivery_amount, order_total, billing_name,
                    billing_company, billing_email, billing_contact, billing_address, delivery_name,
                    delivery_company, delivery_email, delivery_contact, delivery_address, delivery_note,
                    payment_method, order_datetime, order_status
					FROM tbl_orders
					WHERE order_id = '".$order_id."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
	
		if (count($result) > 0) {		
			$details = array(
                "cart_id"=>$result[0][0], 
                "user_id"=>$result[0][1], 
                "cart_total"=>$result[0][2], 
                "delivery_amount"=>$result[0][3], 
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
	
	function getBankPaymentsToBeApproved(){
		// DATE_FORMAT(request_date,'%Y-%m-%d')
		$query = "  SELECT order_id, cart_id, user_id, cart_total, delivery_amount, order_total, billing_name, billing_company, billing_email,
                    billing_contact, billing_address, delivery_name, delivery_company, delivery_email, delivery_contact, delivery_address,
                    delivery_note, payment_method, order_datetime, order_status
                    FROM tbl_orders 
                    WHERE payment_method = 'BANK' AND 
                          order_status = 'PENDING_APPROVAL' 
                    ORDER BY order_datetime DESC;  ";

		//$this -> logData($query);
									
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {
			$details["order_id".($i+1)] = $result[$i][0];
			$details["cart_id".($i+1)] = $result[$i][1];
			$details["user_id".($i+1)] = $result[$i][2];
			$details["cart_total".($i+1)] = $result[$i][3];
            $details["delivery_amount".($i+1)] = $result[$i][4];
            $details["order_total".($i+1)] = $result[$i][5];
			$details["billing_name".($i+1)] = $result[$i][6];
			$details["billing_company".($i+1)] = $result[$i][7];
			$details["billing_email".($i+1)] = $result[$i][8];
            $details["billing_contact".($i+1)] = $result[$i][9];
			$details["billing_address".($i+1)] = $result[$i][10];
			$details["delivery_name".($i+1)] = $result[$i][11];
			$details["delivery_company".($i+1)] = $result[$i][12];
            $details["delivery_email".($i+1)] = $result[$i][13];
			$details["delivery_contact".($i+1)] = $result[$i][14];
			$details["delivery_address".($i+1)] = $result[$i][15];
			$details["delivery_note".($i+1)] = $result[$i][16];
            $details["payment_method".($i+1)] = $result[$i][17];
			$details["order_datetime".($i+1)] = $result[$i][18];
			$details["order_status".($i+1)] = $result[$i][19];
			
			$i +=1;
		}
		return $details;
	}
	
	function getOrdersToBeShipped(){
		// DATE_FORMAT(request_date,'%Y-%m-%d')
		$query = "  SELECT order_id, cart_id, user_id, cart_total, delivery_amount, order_total, billing_name, billing_company, billing_email,
                    billing_contact, billing_address, delivery_name, delivery_company, delivery_email, delivery_contact, delivery_address,
                    delivery_note, payment_method, order_datetime, order_status
                    FROM tbl_orders 
                    WHERE order_status = 'PAYMENT_APPROVED' 
                    ORDER BY order_datetime DESC;  ";
									
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {
			$details["order_id".($i+1)] = $result[$i][0];
			$details["cart_id".($i+1)] = $result[$i][1];
			$details["user_id".($i+1)] = $result[$i][2];
			$details["cart_total".($i+1)] = $result[$i][3];
            $details["delivery_amount".($i+1)] = $result[$i][4];
            $details["order_total".($i+1)] = $result[$i][5];
			$details["billing_name".($i+1)] = $result[$i][6];
			$details["billing_company".($i+1)] = $result[$i][7];
			$details["billing_email".($i+1)] = $result[$i][8];
            $details["billing_contact".($i+1)] = $result[$i][9];
			$details["billing_address".($i+1)] = $result[$i][10];
			$details["delivery_name".($i+1)] = $result[$i][11];
			$details["delivery_company".($i+1)] = $result[$i][12];
            $details["delivery_email".($i+1)] = $result[$i][13];
			$details["delivery_contact".($i+1)] = $result[$i][14];
			$details["delivery_address".($i+1)] = $result[$i][15];
			$details["delivery_note".($i+1)] = $result[$i][16];
            $details["payment_method".($i+1)] = $result[$i][17];
			$details["order_datetime".($i+1)] = $result[$i][18];
			$details["order_status".($i+1)] = $result[$i][19];
			
			$i +=1;
		}
		return $details;
	}	
	
	function approveBankPayment($id){
	
		$query = " 	UPDATE tbl_orders 
					SET order_status = 'PAYMENT_APPROVED'				
					WHERE order_id = '".$id."' AND payment_method = 'BANK'; ";			
		
		$result = "";
		$result = $this -> executeUpdateQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}	

	function shipOrder($id){
	
		$query = " 	UPDATE tbl_orders 
					SET order_status = 'SHIPPED'				
					WHERE order_id = '".$id."'; ";			
		
		$result = "";
		$result = $this -> executeUpdateQuery($query);
			
		$msg = "";
		if($result)
			$msg = 'SUCCESS';
		else
			$msg = 'ERROR';
				
		return $msg;	
	}

	function searchOrders($orderId,$orderState,$fromDate,$toDate) {
		if($orderState == "-") {
			$orderState = "";
		}
		
		$query = "  SELECT order_id, order_total, order_status, order_datetime
					FROM tbl_orders
					WHERE order_id like '%".$orderId."%' AND order_status like '%".$orderState."%'
					AND DATE_FORMAT(order_datetime, '%Y-%m-01') >= '".$this -> dateconvert($fromDate,1)."' 
					AND DATE_FORMAT(order_datetime, '%Y-%m-01') <= '".$this -> dateconvert($toDate,1)."' ; ";

		//$this -> logData($query);		
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		$details = "";
		while ($i < count($result)) {
			$details["order_id".($i+1)] = $result[$i][0];
			$details["order_total".($i+1)] = $result[$i][1];
			$details["order_status".($i+1)] = $result[$i][2];
			$details["order_datetime".($i+1)] = $result[$i][3];
			
			$i +=1;
		}
		return $details;
	}	
}
?>

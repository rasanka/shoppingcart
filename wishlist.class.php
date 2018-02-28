<?php
require_once("db_manager.class.php");

class Wishlist extends DB_Manager {


	function loadWishListByUserId($user_id){
	
		$query = "  SELECT prod_id
					FROM tbl_wishlist
					WHERE user_id = '".$user_id."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		$i = 0;
		$details = array();
		//$details = "";
		while ($i < count($result)) {		
				
			$details["prod_id".($i+1)] = $result[$i][0];
			$i +=1;
		}
		
		return $details;
	
	}

	function checkWishList($user_id, $prod_id){
	
		$query = "  SELECT count(*)
					FROM tbl_wishlist
					WHERE user_id = '".$user_id."' AND prod_id = '".$prod_id."'; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);

		if(count($result) > 0){
			$details = array("record_count"=>$result[0][0]);
		}
		
		return $details;
	
	}	

	function addToWishList($user_id, $prod_id) {

		$details = $this -> checkWishList($user_id, $prod_id);
		$msg = "";

		if($details['record_count'] > 0) {
			$msg = "DUPLICATE";
		} else {

			$query = "INSERT INTO tbl_wishlist (user_id, prod_id) VALUES('".$user_id."','".$prod_id."'); ";

			$result = "";
			$result = $this -> executeInsertQuery($query);
							
			if($result){				
				$msg = 'SUCCESS';
			}else {
				$msg = 'ERROR';
			}
		}		
		return $msg;		
	}	

	function removeFromWishList($user_id, $prod_id) {

		$query = "DELETE FROM tbl_wishlist WHERE user_id = '".$user_id."' AND prod_id = '".$prod_id."'; ";

		$result = "";
		$result = $this -> executeDeleteQuery($query);
							
		if($result){				
			$msg = 'SUCCESS';
		}else {
			$msg = 'ERROR';
		}	
		return $msg;		
	}	
}
?>
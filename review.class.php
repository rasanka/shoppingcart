<?php
require_once("db_manager.class.php");

class Review extends DB_Manager { 
	
	function saveReview($prod_id,$rating,$msg,$name,$email){

		$query = "INSERT INTO tbl_product_reviews (prod_id, rating, review, name, email, review_date) 
				  VALUES(".$prod_id.",".$rating.",'".$msg."','".$name."','".$email."',now()); ";

		$revId = 0;
		$revId = $this -> executeInsertQueryReturnID($query);
			
		return $revId;
	}

	function getReviewDetailsById($id){
	
		$query = "  SELECT prod_id, rating, review, name, email, review_date
					FROM tbl_product_reviews
					WHERE review_id = ".$id."; ";
				 
		$result = "";
		$result = $this -> executeQuery($query);	
		
		if(count($result) > 0){
			$details = array("prod_id"=>$result[0][0],"rating"=>$result[0][1],"review"=>$result[0][2],"name"=>$result[0][3],"email"=>$result[0][4],"review_date"=>$result[0][5]);
			return $details;
		}else{
			return "NO_DATA";
		}
	
	}	
	
	function loadReviewsByProdId($prod_id){
	
      	$query = "  SELECT review_id, rating, review, name, email, DATE_FORMAT(review_date,'%d %b %Y')
					FROM tbl_product_reviews
					WHERE prod_id = ".$prod_id."
                    ORDER BY review_date DESC; ";
      			 
		$result = "";
		$result = $this -> executeQuery($query);	
	
        $details = array();
		if (count($result) > 0) {			
		
		    $i = 0;
		    while ($i < count($result)) {		
				
			    $details["review_id".($i+1)] = $result[$i][0];
                $details["rating".($i+1)] = $result[$i][1];
                $details["review".($i+1)] = $result[$i][2];
                $details["name".($i+1)] = $result[$i][3];
                $details["email".($i+1)] = $result[$i][4];
                $details["review_date".($i+1)] = $result[$i][5];
                
			    $i +=1;
		    }
		}
		
		return $details;
	
	}     

}
?>

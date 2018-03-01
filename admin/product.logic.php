<?php
require_once ("config/config.php");
require_once ("product.class.php");
require_once ("logger.class.php");
	
$m_chksql = $_POST['chksql'];

$prodObj   = new Product();
$logObj   = new Logger();

if($m_chksql == "saveProduct"){	

	$prod_id= $_POST['id'];
	$name= $_POST['name'];
    $cat_id= $_POST['cat_id'];
	$brand_id= $_POST['brand_id'];
	$ref_id= $_POST['ref_id'];
	$status= $_POST['status'];

	//$logObj -> logData($name."-".$cat_id."-".$brand_id."-".$desc."-".$price."-".$stock."-".$ref_id."-".$supplier."-".$status);

	$result = $prodObj -> saveProduct($prod_id,$name,$cat_id,$brand_id,$ref_id,$status); 

	$msg = 'ERROR';
	if($result == 'SUCCESS') {

		//$logObj -> logData('PROD ID -'.$prod_id);

		$directory = "../product_images/".$prod_id."/";
		$filecount = 0;
		if (glob($directory . "*.*") != false){
			$filecount = count(glob($directory . "th_*.*"));
		}else{
			$filecount = 0;
		}

		//$logObj -> logData('File Count -'.$filecount);
				
		if($filecount > 0){
			$images = glob($directory . "th_*.*");
			
			$i = 1;
			foreach($images as $thumburl){
				$imageurl = '';
				$imageurl = str_replace("th_","",$thumburl);

				//$logObj -> logData('IMG URL '.$i.' - '.$imageurl);
				//$logObj -> logData('THMB URL -'.$thumburl);

				$image_name = substr($imageurl,strripos($imageurl, '/')+1,strlen($imageurl));

				//$logObj -> logData('IMG -'.$image_name);	

				$msg = $prodObj -> saveProductImage($prod_id, $i, $image_name);
				$i++;
			}
		}
	}

	echo $msg;	
}

if($m_chksql == "updateProduct"){	

	$id = $_POST['id'];
	$name= $_POST['name'];
    $cat_id= $_POST['cat_id'];
	$brand_id= $_POST['brand_id'];
	$ref_id= $_POST['ref_id'];
	$status= $_POST['status'];

	$msg = '';
	$msg = $prodObj -> updateProduct($id,$name,$cat_id,$brand_id,$status); 

	if($msg == 'SUCCESS') {
		// Deleting the product images and re-inserting during the update to get the latest
		$msg = $prodObj -> deleteProductImages($id);

		// Re-inserting the images
		$directory = "../product_images/".$ref_id."/";
		$filecount = 0;
		if (glob($directory . "*.*") != false){
			$filecount = count(glob($directory . "th_*.*"));
		}else{
			$filecount = 0;
		}

		//$logObj -> logData('File Count -'.$filecount);
		
		$msg = '';
		if($filecount > 0){
			$images = glob($directory . "th_*.*");
			
			$i = 1;
			foreach($images as $thumburl){
				$imageurl = '';
				$imageurl = str_replace("th_","",$thumburl);

				//$logObj -> logData('IMG URL '.$i.' - '.$imageurl);
				//$logObj -> logData('THMB URL -'.$thumburl);

				$image_name = substr($imageurl,strripos($imageurl, '/')+1,strlen($imageurl));

				//$logObj -> logData('IMG -'.$image_name);	

				$msg = $prodObj -> saveProductImage($id, $i, $image_name);
				$i++;
			}
		}
	}
	echo $msg;	
}

if($m_chksql == "deleteProduct"){	

	$id = $_POST['id'];
	$level = $_SESSION["ses_user_level"];

	$details = $prodObj -> getProductDetailsById($id);
	
	$msg = '';
	if($level == "ADMIN"){
		$msg = $prodObj -> deleteProduct($id); 

		$dirPath = "../product_images/".$details['ref_id']."/";	

		$files = glob($dirPath . '*', GLOB_MARK);
    	foreach ($files as $file) {
        	unlink($file);
    	}
    	rmdir($dirPath);		

		$msg = $prodObj -> deleteProductImages($id); 
	}
	echo $msg;	
}

if($m_chksql == "loadProductList"){	
	
	$returnStr = "";
	$selStr = "<select name='products' id='products' class='body' onChange=''><option value='-'> -- Please Select --</option>";
	$optStr = "";
	$details = array();
	$details = $prodObj -> getProductList();  
		
	//$logObj -> logData('DATA -'.count($details));	
	$i = 0;
	while ($i < count($details)) {
		$optStr = $optStr."<option value='".$details[$i][0]."'>".$details[$i][0]." - ".strtoupper($details[$i][1])."</option>";			
		$i +=1;
	}
	
	$returnStr = $selStr.$optStr."</select>";
	echo $returnStr;	

}

if($m_chksql == "loadRatingList"){
	$status = "";
	$status = " <select name='rating_select' id='rating_select' class='body'>
					<option value='1'>1 Star</option>
                    <option value='2'>2 Star</option>
					<option value='3'>3 Star</option> 
					<option value='4' selected>4 Star</option> 
					<option value='5'>5 Star</option>                                   
				</select> ";

	echo $status;			
}

if($m_chksql == "loadBadgeList"){
	$status = "";
	$status = " <select name='badge_select' id='badge_select' class='body'>
					<option value='NEW' selected>NEW</option>
                    <option value='SALE'>SALE</option>  
					<option value='HOT'>HOT</option>                                      
				</select> ";

	echo $status;			
}

if($m_chksql == "loadStatusList"){
	$status = "";
	$status = " <select name='status_select' id='status_select' class='body'>
					<option value='SHOW' selected>Display Product</option>
                    <option value='HIDE'>Hide Product</option>                                  
				</select> ";

	echo $status;			
}

if($m_chksql == "deleteProductImage")
{	
	$ref_id   = $_POST['ref_id'];
	$thumbnail    = $_POST['url'];
	
	$directory = "../product_images/".$ref_id."/";	
	
	$filename = str_replace("th_","",$thumbnail);
	
	if (file_exists($filename)) {
		unlink($filename); 
		unlink($thumbnail);
	}
	 
	//get all image files with a .jpg extension.
	$images = glob($directory . "th_*.*");
	$files = ""; 
	foreach($images as $image){
		$files = $files.$image."@";
	}	
	echo $files;	
}

if($m_chksql == "searchProducts"){	

	$name = $_POST['name'];
	$cat_id = $_POST['cat_id'];
	$brand = $_POST['brand'];
	$ref_id = $_POST['ref_id'];

	$item_details = array();	
	$item_details = $prodObj -> searchProducts($name,$cat_id,$brand,$ref_id);  
	
	if(count($item_details) > 1){
	
		$m_out = $m_out."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='body'>
						  <tr class='heading' height='20'>
							<th width='10%' align='left'>Product ID</td>
							<th width='30%' align='left'>Title</td>
							<th width='20%' align='left'>Ref ID (SKU)</td>
							<th width='20%' align='left'>Create Date</td>
							<th width='10%'>Edit</td>
							<th width='10%'>Delete</td>
						  </tr> ";
		
		$num = 0;
		$color = "";
		$rowCount = 1;
		$i = 0;

		while($i < (count($item_details)/4)){

			$m_out = $m_out."<tr height='20' style='color:#009900' onMouseOver=this.className='reorderhighlight' onMouseOut=this.className='reordernormal'>   
								<td>".$item_details['prod_id'.$rowCount]."</td> 
								<td>".$item_details['prod_name'.$rowCount]."</td> 
								<td>".$item_details['ref_id'.$rowCount]."</td> 
								<td>".$item_details['created_date'.$rowCount]."</td> 
								<td align='center'><a href='edit_product.php?id=".$item_details['prod_id'.$rowCount]."'>Edit</a></td>
								<td align='center'><a onClick='deleteProduct(".$item_details['prod_id'.$rowCount].");'>Delete</a></td>
							</tr>  ";	
				
			$rowCount += 1;		
			$i += 1;			
		}
				
		$m_out = $m_out."</table>";						
											
	} else {
		$m_out = $m_out."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='body'> ".
				 " <tr>  ".
				 "	<td>&nbsp;</td> ".
				 " </tr> ".		
				 " <tr height='20'>  ".
				 "	<td align='center'>No Records Found!</td> ".
				 " </tr> ".
				 " <tr>  ".
				 "	<td>&nbsp;</td> ".
				 " </tr> ".				 
				 "</table>";
	}
	echo $m_out;		
}

?>

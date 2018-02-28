<?php
$ref_id = "";
$type = $_FILES["uploadfile"]["type"];
$ext  = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
$name = $_FILES["uploadfile"]["name"];
$ref_id = $_POST["vid"];

if($ref_id != ""){
	define("UPLOAD_DIR","../product_images/".$ref_id."/");
	define("SOURCE", $_FILES["uploadfile"]["tmp_name"]);
	define("FILENAME", strtolower($_FILES["uploadfile"]["name"]));
		  
	require_once("oiu.class.php"); 
	
	if(!is_file(UPLOAD_DIR.FILENAME)){
	
		$img_width  = 400; 
		$img_height = 0;   
		
		$th_width   = 125; 
		$th_height  = 100;  
			
		if($oiu->CreateImage($img_width, $img_height, $th_width, $th_height, $ref_id, $ext) === false){
			echo "Upload error";
		}else{ 
			$directory = "../product_images/".$ref_id."/";
			$filecount = 0;
			if (glob($directory . "*.*") != false){
				$filecount = count(glob($directory . "th_*.".$ext));
			}else{
				$filecount = 0;
			}
			echo "success#".$filecount; 
		}
	}else{ 
		echo "Upload error: ".$name." already exists!";
	}
}
else{ 
	echo "Please Contact Admin!";
}
			

?>
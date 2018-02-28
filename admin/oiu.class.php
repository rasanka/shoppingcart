<?php
class ImageUpload { 

	protected $UPLOAD_DIR = UPLOAD_DIR;
	protected $SOURCE     = SOURCE;
	protected $FILENAME   = FILENAME;
	public $NEWNAME = "";
	public $THUMBNAIL = "";
	
	public function defineUploadDirectory($v_ID){
		if(!defined("UPLOAD_DIR")){ 
			define("UPLOAD_DIR", "../product_images/".$v_ID."/");
		}
	}
	
	public function CreateImage($img_W, $img_H, $th_W, $th_H, $v_ID, $ext){

		$this -> defineUploadDirectory($v_ID);
		$this->stretch = 0; 

		if(!is_dir($this->UPLOAD_DIR)){ 
			mkdir($this->UPLOAD_DIR); chmod($this->UPLOAD_DIR, 0777);
    	}
		
		$directory = "../product_images/".$v_ID."/";
		$filecount = 0;
		if (glob($directory . "*.*") != false){
			$filecount = count(glob($directory . "th_*.".$ext));
		}else{
		 	$filecount = 0;
		}
		
		$NEWNAME = $directory.trim($v_ID)."_".($filecount+1).".".$ext;
		$THUMBNAIL = $directory."th_".trim($v_ID)."_".($filecount+1).".".$ext;
		
		if((move_uploaded_file($this->SOURCE, $NEWNAME)) === false){
			trigger_error('Could not upload to '.$this->UPLOAD_DIR, E_USER_WARNING);
     		return(false);
		}
		$type = getimagesize($NEWNAME);
		
		switch($type[2]){
			case '1':
			$icf  = "imagecreatefromgif";
			$img  = "imagegif";
			$qlty = "80"; # Set quality %
			break;
			case '2':
			$icf  = "imagecreatefromjpeg";
			$img  = "imagejpeg";
			$qlty = "80"; # Set quality %
			break;
			case '3':
			$icf  = "imagecreatefrompng";
			$img  = "imagepng";
			$qlty = "9"; # DONOT CHANGE
			break;
		}
		if(!function_exists($icf)){ 
			@unlink($NEWNAME);
			trigger_error('GD extensions are not loaded!', E_USER_WARNING);
     		return(false);
		}
		list($org_W, $org_H) = getimagesize($NEWNAME);
		
		if($this->stretch == 0){		
			if($org_W < $img_W){ 
				$img_W = $org_W;
      		}
			if($img_H > 0 && $org_H < $img_H){ 
				$img_H = $org_H;
			}
			elseif($img_H == 0){
				$proportion = ($org_H/$org_W);
				$img_H = ($img_W*$proportion);
			}
		}else{		
      		if($img_H == 0){
		   		$proportion = ($org_H/$org_W);
       			$img_H = ($img_W*$proportion);
      		}
		}
		$src = $icf($NEWNAME);
	  	if($img_W > 0){
			$img_tmp = imagecreatetruecolor($img_W, $img_H);
			imagecopyresampled($img_tmp, $src, 0, 0, 0, 0, $img_W, $img_H, $org_W, $org_H);
			$img($img_tmp, $NEWNAME, $qlty);
			imagedestroy($img_tmp); # free image from memory
		}
		if($th_W > 0){
			if($th_H == 0){
       			$proportion = ($org_H/$org_W);
       			$th_H = ($th_W*$proportion);
      		}
		    $th_tmp = imagecreatetruecolor($th_W, $th_H);
    		imagecopyresampled($th_tmp, $src, 0, 0, 0, 0, $th_W, $th_H, $org_W, $org_H);
    		$img($th_tmp, $THUMBNAIL, $qlty);
    		imagedestroy($th_tmp); # free image from memory
		}
	}
}
$oiu = new ImageUpload(); # Instantiate class
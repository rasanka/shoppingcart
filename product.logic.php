<?php
	session_start();

	require_once("wishlist.class.php");
	require_once("item.class.php");
	
	$wishlistObj = new Wishlist();
	$itemObj = new Item();
	
	if(isset($_POST['add_to_wishlist'])) {

		if(isset($_SESSION['sitid'])  && $_SESSION['sitid'] !== "") {

			$uid = $_SESSION['sitid'];
			$pid = $_POST['product_id'];
      $msg = '';
      $msg_type = '';

			$result = $wishlistObj -> addToWishList($uid, $pid);

      if($result == "DUPLICATE") {
        $msg = "Product already added to Wishlist";
        $msg_type = "alert-warning";
      } else if($result == "SUCCESS") {
        $msg =  "Prodct successfully added to Wishlist";
        $msg_type = "alert-success";
      } else {
        $msg =  "Error occured. Please Try again!";
        $msg_type = "alert-warning";
      }

      $html = "
        <div class='alert ".$msg_type."'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>".$msg."</b>
        </div> ";
      echo $html;	   		
		} else {
			echo "LOGIN";
		}
		
	}

	if(isset($_POST['remove_from_wishlist'])) {

		$uid = $_SESSION['sitid'];
		$pid = $_POST['product_id'];
    $msg = '';
    $msg_type = '';

  	$result = $wishlistObj -> removeFromWishList($uid, $pid);

     if($result == "SUCCESS") {
      $msg =  "Prodct successfully removed from Wishlist";
      $msg_type = "alert-success";
    } else {
      $msg =  "Error occured. Please Try again!";
      $msg_type = "alert-warning";
    }

    $html = "
      <div class='alert ".$msg_type."'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>".$msg."</b>
      </div> ";
    echo $html;	   		
		
	}  
	
	if(isset($_POST['product_quick_view'])) {

		$pid = $_POST['product_id'];

		$details = array();
		$details = $itemObj -> loadItemByID($pid);
    	$prod_image = $itemObj -> loadMainItemImage($pid);

		echo "   <div class='modal-dialog'>
                  <div class='modal-content'>                      
                    <div class='modal-body'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                      <div class='row'>
                        <!-- Modal view slider -->
                        <div class='col-md-6 col-sm-6 col-xs-12'>                              
                          <div class='aa-product-view-slider'>                                
                            <div class='simpleLens-gallery-container' id='demo-1'>
                              <div class='simpleLens-container'>
                                  <div class='simpleLens-big-image-container'>
                                      <a>
                                          <img href='index.php?page=item&pid=".$pid."' width='250' height='300' src='item_images/".$pid."/".$prod_image['image_name']."' class='simpleLens-big-image'>
                                      </a>
                                  </div>
                              </div>
                              <div class='simpleLens-thumbnails-container'> "; 

    $img_array = array();

    $img_array = $itemObj ->  loadItemImagesByID($pid);
                      
    if(count($img_array) > 0){

      $j = 0;
      $itemCount = 1;
      
      while($j < (count($img_array)/2)){

        echo "
            <a href='#' class='simpleLens-thumbnail-wrapper'
              data-big-image='item_images/".$pid."/".$img_array['image_name'.$itemCount]."'>
                <img width='45' height='55'  src='item_images/".$pid."/".$img_array['image_name'.$itemCount]."'>
            </a>                  
        ";

        $itemCount += 1;
        $j +=1;
      }

    }

    echo "                 </div>
                            </div>
                          </div>
                        </div>
                        <!-- Modal view content -->
                        <div class='col-md-6 col-sm-6 col-xs-12'>
                          <div class='aa-product-view-content'>
                            <h3>".$details['item_name']."</h3>
                            <div class='aa-price-block'>
                              <span class='aa-product-view-price'>$".$details['item_price']."</span>
                              <p class='aa-product-avilability'>Avilability: <span>In stock</span></p>
                            </div>
                            <p>".$details['short_desc']."</p>
                            <div class='aa-prod-quantity'>
                              <form action=''>
                                <select name='product_qty' id='product_qty'>
                                  <option value='1' selected='1'>1</option>
                                  <option value='2'>2</option>
                                  <option value='3'>3</option>
                                  <option value='4'>4</option>
                                  <option value='5'>5</option>
                                  <option value='6'>6</option>
                                </select>
                              </form>
                            </div>
                            <div class='aa-prod-view-bottom'>
                              <a href='index.php?page=cart'  pid='".$pid."' pprice='".$details['item_price']."'  class='aa-add-to-cart-btn'><span class='fa fa-shopping-cart'></span>Add To Cart</a>
                              <a href='index.php?page=item&pid=".$pid."' class='aa-view-details-btn'>View Details</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>                        
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->";
	}

?>
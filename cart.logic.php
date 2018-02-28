<?php 

	session_start();

	require_once("cart.class.php");
    require_once("product.class.php");
    require_once("common.class.php");
	require_once("item.class.php");

	$cartObj = new Cart();
    $productObj = new Product();
	$itemObj = new Item();
    $commonObj = new Common();

    if(isset($_POST['add_to_cart'])) {

        $prod_id = $_POST['product_id'];
        $prod_price = $_POST['product_price'];

        //$commonObj -> logData('Adding to Cart -'.$prod_id.' price -'.$prod_price);

        if(!isset($_SESSION['sitid'])) {
            echo "LOGIN";
        } else {
            $user_id = $_SESSION['sitid'];
            $cart_arr = $cartObj -> isCartAvailable($user_id,'INCOMPLETE');
            $msg = '';
            $msg_type = '';
            //$commonObj -> logData('User -'.$user_id.' cart count -'.$cart_arr['cart_count']);

            if(isset($_SESSION['sitcart']) && $cart_arr['cart_count'] > 0) {

                $cart_id = $_SESSION['sitcart'];
                //$commonObj -> logData('Existing Cart -'.$cart_id);

                $details = $cartObj -> isItemInCart($cart_id, $prod_id);
		        if($details['item_count'] > 0) {

                    //$commonObj -> logData('Item '.$prod_id.' already in Cart -'.$cart_id);
                    $msg = "Product already added to Cart";
                    $msg_type = "alert-warning";
                } else {

                    //$commonObj -> logData('Updating in Cart -'.$cart_id);
                    $status = $cartObj -> updateCart($_SESSION['sitcart'], $prod_id, 1, $prod_price); 
                    if($status) {
                        $msg =  "Prodct successfully added to Cart";
                        $msg_type = "alert-success";
                    } else {
                        $msg =  "Error occured. Please Try again!";
                        $msg_type = "alert-warning";
                    }
                }
            } else {
                //$commonObj -> logData('Creating Cart -'.$user_id.' - '.$prod_id);

                $cart_id = $cartObj -> createCart($user_id, $prod_id, 1, $prod_price);
                $_SESSION['sitcart'] = $cart_id;

                //$commonObj -> logData('Cart CREATED-'.$cart_id);
                $msg = "Prodct successfully added to Cart";
                $msg_type = "alert-success";
            }

            $html = "
                <div class='alert ".$msg_type."'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>".$msg."</b>
                </div> ";
            echo $html;	            
        }
    }

    if(isset($_POST['get_cart_qty'])) {
        $cart_id = $_SESSION['sitcart'];

        $cart = $cartObj -> getCartQty($cart_id);

        echo $cart['qty_count'];
    }

    if(isset($_POST['load_cart_items'])) {

        if(isset($_SESSION['sitid'])) {
            $user_id = $_SESSION['sitid'];
            $cart_array = array();
            $cart_array = $cartObj -> loadCartByUserId($user_id);

            $cart_summary = "";
            $cart_items_html = "";
            $cart_item_count = 0;         
            $total_item_count  = 0;

            if(count($cart_array) > 0){
                        
                $cart_id = $cart_array['cart_id'];
                $total_price = $cart_array['total_price'];

                $item_array = array();
                $item_array = $cartObj -> loadCartItemsById($cart_id);                        

                $j = 0;
                $itemCount = 1;
                $cart_item_count = (count($item_array)/3);
                while($j < $cart_item_count){

                    $prod_id = $item_array['prod_id'.$itemCount];
                    $prod_qty = $item_array['qty'.$itemCount];

                    $total_item_count  += $prod_qty; 

                    $prod_array = array();
                    $prod_array = $itemObj ->loadItemByID($prod_id); 

                    $prod_image = $itemObj -> loadMainItemImage($prod_id);

                    if(count($prod_array) > 0){
                            
                        $cart_items_html = $cart_items_html. "
                            <li id='row".$itemCount."'>
                                <a class='aa-cartbox-img' href='index.php?page=product&pid=".$prod_id."'><img width='150' height='150' src='item_images/".$prod_array['ref_id']."/".$prod_image['image_name']."' alt='img'></a>
                                <div class='aa-cartbox-info'>
                                    <h4><a href='index.php?page=product&pid=".$prod_id."'>".$prod_array['prod_name']."</a></h4>
                                    <p>".$prod_qty." x $".$prod_array['prod_price']."</p>
                                </div>
                                <a pid=".$prod_id." rowid=".$itemCount." class='aa-remove-product' href='#'><span class='fa fa-times'></span></a>
                            </li>                         
                            ";
                    }

                    $itemCount += 1;
                    $j +=1;
                }

                $cart_summary = "
                    <ul>                    
                        ".$cart_items_html."                                      
                        <li>
                        <span class='aa-cartbox-total-title'>
                            Total
                        </span>
                        <span class='aa-cartbox-total-price'>
                            $".$total_price."
                        </span>
                        </li> 
                    </ul>
                    <a class='aa-cartbox-checkout aa-primary-btn' href='index.php?page=checkout'>Checkout</a>  
                    ";          
                            
            } else {
                $cart_summary = "No Product added to the Cart!";
            }
        } else {
            $cart_summary = "No Product added to the Cart!";
        }
        echo $cart_summary;
    }

    if(isset($_POST['update_cart'])) {

        $cart_id = $_SESSION['sitcart'];
        $prod_id = $_POST['product_id'];
        $prod_qty = $_POST['product_qty'];
        $prod_price = $_POST['product_price'];

        if(!isset($_SESSION['sitid'])) {
            echo "LOGIN";
        } else {
            $user_id = $_SESSION['sitid'];
            $cart_arr = $cartObj -> isCartAvailable($user_id,'INCOMPLETE');

            if(isset($_SESSION['sitcart']) && $cart_arr['cart_count'] > 0) {
                $status = $cartObj -> updateCart($cart_id, $prod_id, $prod_qty, $prod_price);
                if($status) { 
                    echo "Cart updated Successfully";
                } else {
                    echo "Error occured. Please Try again!";
                }
            } else {
                $cart_id = $cartObj -> createCart($user_id, $prod_id, $prod_qty, $prod_price);
                $_SESSION['sitcart'] = $cart_id;
                echo "Prodct successfully added to Cart";
            }           
        }
    }   

    if(isset($_POST['update_cart_quantity'])) {

        $cart_id = $_POST['cart_id'];
        $prod_id = $_POST['product_id'];
        $prod_qty = $_POST['product_qty'];
        $prod_price = $_POST['product_price'];

        $status = $cartObj -> updateCartQty($cart_id, $prod_id, $prod_qty, $prod_price);

        if($status){
            echo "OK";
        } else {
            echo "ERROR";
        }
    }  

    if(isset($_POST['remove_item'])) {

        $cart_id = 0;
        if(isset($_POST['cart_id'])) {
            $cart_id = $_POST['cart_id'];
        } else {
            $cart_id = $_SESSION['sitcart'];
        }
        $prod_id = $_POST['product_id'];

        $status = $cartObj -> removeItemFromCart($cart_id, $prod_id);

        $cart = $cartObj -> getCartQty($cart_id);
        $cart_qty = $cart['qty_count'];

        if($cart_qty == "" || $cart_qty == null) {
            $cart_qty = 0;
        }   

        $cart_tot = $cartObj -> getCartTotal($cart_id);
        $total_amount = $cart_tot['cart_total'];

        if($cart_qty == "" || $cart_qty == null) {
            $cart_qty = 0;
        }                     

        $cart_exsist = $cartObj -> isCartExsist($cart_id);

        if($cart_exsist['cart_exsist'] > 0) {
            echo $cart_qty.'@'.$total_amount;
        } else {
            echo '<script type="text/javascript">location.reload(true);</script>';
        }
    }         

?>
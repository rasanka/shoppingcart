    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Cart</li>
            </ol>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4>CART</h4>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 hidden-xs"><span class="font-size"> <a href="#">-</a> <i class="fa fa-font"></i> <a href="#">+</a></span></div>
          <!-- end col-4 -->
        </div>
      </div>
    </section>

<?php if(isset($_SESSION['sitid'])) { 


  require_once("cart.class.php");
  require_once("item.class.php");

  $cartObj = new Cart();
  $itemObj = new Item();

  $user_id = $_SESSION['sitid'];
  $cart_array = array();
  $cart_array = $cartObj -> loadCartByUserId($user_id);

  $cart_items_html = "";
                      
  if(count($cart_array) > 0){

    $cart_id = $cart_array['cart_id'];
    $total_price = $cart_array['total_price'];

    $item_array = array();
    $item_array = $cartObj -> loadCartItemsById($cart_id);  

    $j = 0;
    $itemCount = 1;
    while($j < (count($item_array)/3)){

      $prod_id = $item_array['prod_id'.$itemCount];
      $prod_qty = $item_array['qty'.$itemCount];

      $prod_array = array();
      $prod_array = $itemObj ->loadItemByID($prod_id); 

      $prod_image = $itemObj -> loadMainItemImage($prod_id);

      if(count($prod_array) > 0){

        $cart_items_html = $cart_items_html."
          <tr id='row".$itemCount."'>
            <td><a pid=".$prod_id." rowid=".$itemCount." class='remove' href='#'><fa class='fa fa-close'></fa></a></td>
            <td><a href='index.php?page=product&pid=".$prod_id."'><img width='250' height='300' src='item_images/".$prod_id."/".$prod_image['image_name']."' alt='img'></a></td>
            <td><a class='aa-cart-title' href='index.php?page=item&pid=".$prod_id."'>".$prod_array['item_name']."</a></td>
            <td>$".$prod_array['item_price']."</td>
            <td><input id='prod_qty".$itemCount."' class='aa-cart-quantity' min='1' max='10'
                itmid=".$itemCount." 
                pprice=".floatval($prod_array['item_price'])." 
                pid=".$prod_id." 
                type='number' value='".$prod_qty."'></td>
            <td><div id='aa-item-total".$itemCount."'>$".floatval(floatval($prod_array['item_price']) * intval($prod_qty))."</div></td>
          </tr> ";
      }

      $itemCount += 1;
      $j +=1;
    }
                        
  } else {
    $cart_items_html = "    
      <div class='col-md-12' id='message_div'>
        <div class='alert alert-warning'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>No Product added to the Cart!</b>
        </div>        
      </div>
    ";
  }

?>


 <!-- Cart view section -->
 <section id="cart-view">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="cart-view-area">
           <div class="cart-view-table">

             <?php if(count($cart_array) > 0){  ?> 
             <form action="">
               <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th></th>
                        <th></th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php echo $cart_items_html; ?>
                      <tr>
                        <td colspan="6" class="aa-cart-view-bottom">
                          <input type="hidden" id="cart_id" name="cart_id" value="<?php echo $cart_id; ?>">
                          <div class="aa-cart-coupon">
                            <input class="aa-coupon-code" type="text" placeholder="Coupon">
                            <input class="aa-cart-view-btn" type="submit" value="Apply Coupon">
                          </div>
                          <input class="aa-cart-view-btn" type="submit" value="Update Cart">                      
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
             </form>
             <!-- Cart Total view -->
             <div class="cart-view-total">
               <h4>Cart Totals</h4>
               <table class="aa-totals-table">
                 <tbody>
                   <tr>
                     <th>Subtotal</th>
                     <td><div id="sub_total_div">$<?php echo $total_price; ?></div></td>
                   </tr>
                   <tr>
                     <th>Total</th>
                     <td><div id="total_div">$<?php echo $total_price; ?></div></td>
                   </tr>
                 </tbody>
               </table>
               <a href="index.php?page=checkout" class="aa-cart-view-btn">Proced to Checkout</a>
             </div>

             <?php } else { echo $cart_items_html; } ?>

           </div>
         </div>
       </div>
     </div>
   </div>
 </section>

<script src="js/jquery.min.js"></script>
<script type="text/javascript">

  $(document).ready(function() {

      $("body").delegate(".remove","click", function(event){
        var pid = $(this).attr('pid');
        var cid = $('#cart_id').val();
        var rid = $(this).attr('rowid');

        $.ajax({
          url : "cart.logic.php",
          method : "POST",
          data : {remove_item:1,cart_id:cid,product_id:pid},
          success : function(data){
            if(data.includes('script')) {
              location.reload(true);
            } else {
              $('#row'+rid).remove();

              var total = 0;
              $("div[id^='aa-item-total']").each(function() {
                total += parseFloat($(this).text().replace(/\D/g,''));
              });

              var itmCount = 0;
              $("input[id^='prod_qty']").each(function() {
                itmCount += parseInt($(this).val());
              }); 
          
              $('.aa-cart-notify').html(itmCount);
              $('#sub_total_div').html('$'+parseFloat(total));
              $('#total_div').html('$'+parseFloat(total));
            }
          }
        });
      });

      $("body").delegate(".aa-cart-quantity","change", function(event){
        event.preventDefault();
        var qty = $(this).val();
        var pprice = $(this).attr('pprice');
        var itmid = $(this).attr('itmid');
        var pid = $(this).attr('pid');
        var cid = $('#cart_id').val();

        if(qty > 10) {
          $(this).val(10);
          qty = 10;
        }

        $.ajax({
          url : "cart.logic.php",
          method : "POST",
          data : {update_cart_quantity:1,cart_id:cid,product_id:pid,product_qty:qty,product_price:pprice},
          success : function(data){
            $('#aa-item-total'+itmid).html('$'+parseFloat(qty*pprice));

            var total = 0;
            $("div[id^='aa-item-total']").each(function() {
              total += parseFloat($(this).text().replace(/\D/g,''));
            });

            var itmCount = 0;
            $("input[id^='prod_qty']").each(function() {
              itmCount += parseInt($(this).val());
            }); 

            $('.aa-cart-notify').html(itmCount);
            $('#sub_total_div').html('$'+parseFloat(total));
            $('#total_div').html('$'+parseFloat(total));

          }
        });
      }); 
  });

</script>
 
 <!-- / Cart view section -->
<?php } else { ?>

<script src="js/jquery.min.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
    window.location.href='index.php?page=account';
  });

</script>

<?php } ?>
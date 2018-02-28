    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">My Orders</li>
            </ol>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4>ORDERS</h4>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 hidden-xs"><span class="font-size"> <a href="#">-</a> <i class="fa fa-font"></i> <a href="#">+</a></span></div>
          <!-- end col-4 -->
        </div>
      </div>
    </section>  

<?php if(isset($_SESSION['sitid'])) { 

  require_once("order.class.php");
  require_once("product.class.php");
  require_once("cart.class.php");
                    
  $orderObj = new Order();
  $productObj = new Product();
  $cartObj = new Cart();

  $user_id = $_SESSION['sitid'];

  $orders_array = array();

  $orders_array = $orderObj -> loadOrdersByUserId($user_id);
  $orders_html = "";
                      
  if(count($orders_array) > 0){

    $j = 0;
    $itemCount = 1;
    
    while($j < (count($orders_array)/8)){

        $qty_array = $cartObj -> getCartQty($orders_array['cart_id'.$itemCount]);

        $orders_html = $orders_html. "
            <tr id='row".$itemCount."'>
                <td>".$orders_array['order_datetime'.$itemCount]."</td>
                <td>".$qty_array['qty_count']."</td>
                <td>$".$orders_array['order_total'.$itemCount]."</td>
                <td>".$orders_array['order_status'.$itemCount]."</td>
                <td><a href='index.php?page=summary&oid=".$orders_array['order_id'.$itemCount]."' class='aa-add-to-cart-btn'>View Order</a></td>
            </tr> ";

        $itemCount += 1;
        $j +=1;
    }

  } else {
    $orders_html = "    
      <div class='col-md-12' id='message_div'>
        <div class='alert alert-warning'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>No Orders to Display!</b>
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

            <div class="col-md-12" id="message_div">
              <!-- Message -->
            </div>

           <div class="cart-view-table aa-wishlist-table">
           <?php if(count($orders_array) > 0){ ?>
             <form action="">
               <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Order Date</th>
                        <th>Qty</th>
                        <th>Total Payment</th>
                        <th>Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php echo $orders_html; ?>  
                    
                    </tbody>
                  </table>
                </div>
             </form>  
           <?php } else { echo $orders_html; } ?>        
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>

<script src="js/jquery.min.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
      // TO DO
  });

</script>
<?php } else { ?>

<script src="js/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
  window.location.href='index.php?page=account';
});

</script>

<?php } ?>

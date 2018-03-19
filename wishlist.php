    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Wishlist</li>
            </ol>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4>WISHLIST</h4>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 hidden-xs"><span class="font-size"> <a href="#">-</a> <i class="fa fa-font"></i> <a href="#">+</a></span></div>
          <!-- end col-4 -->
        </div>
      </div>
    </section>  

<?php if(isset($_SESSION['sitid'])) { 

  require_once("wishlist.class.php");
  require_once("item.class.php");
                    
  $wishListObj = new Wishlist();
  $itemObj = new Item();

  $user_id = $_SESSION['sitid'];

  $wish_array = array();

  $wish_array = $wishListObj -> loadWishListByUserId($user_id);
  $wishlist_items_html = "";
                      
  if(count($wish_array) > 0){

    $j = 0;
    $itemCount = 1;
    
    while($j < (count($wish_array)/1)){

      $prod_id = $wish_array['prod_id'.$itemCount];

      $prod_array = array();
      $prod_array = $itemObj ->loadItemByID($prod_id); 

      $prod_image = $itemObj -> loadMainItemImage($prod_id);

      if(count($prod_array) > 0){
        
        $wishlist_items_html = $wishlist_items_html. "
            <tr id='row".$itemCount."'>
                <td><a pid=".$prod_id." rowid=".$itemCount." class='remove' href='#'><fa class='fa fa-close'></fa></a></td>
                <td><a href='index.php?page=item&pid=".$prod_id."'><img width='250' height='300' src='item_images/".$prod_id."/".$prod_image['image_name']."' alt='img'></a></td>
                <td><a class='aa-cart-title' href='index.php?page=item&pid=".$prod_id."'>".$prod_array['item_name']."</a></td>
                <td>$".$prod_array['item_price']."</td>
                <td>In Stock</td>
                <td><a href='#' pid=".$prod_id." pprice=".$prod_array['item_price']." class='aa-add-to-cart-btn'>Add To Cart</a></td>
            </tr> ";
      }
      $itemCount += 1;
      $j +=1;
    }
  } else {
    $wishlist_items_html = "    
      <div class='col-md-12' id='message_div'>
        <div class='alert alert-warning'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>No Product added to the Wishlist!</b>
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
           <?php if(count($wish_array) > 0){ ?>
             <form action="">
               <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th></th>
                        <th></th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Stock Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php echo $wishlist_items_html; ?>  
                    
                    </tbody>
                  </table>
                </div>
             </form>  
           <?php } else { echo $wishlist_items_html; } ?>        
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>

<script src="js/jquery.min.js"></script>
<script type="text/javascript">

  $(document).ready(function() {


      $("body").delegate(".aa-add-to-cart-btn","click", function(event){
        event.preventDefault();
        var pid = $(this).attr('pid');
        var price = $(this).attr('pprice');
        var qty = 1;

        $.ajax({
          url : "product.logic.php",
          method : "POST",
          data : {remove_from_wishlist:1,product_id:pid},
          success : function(data){
            $.ajax({
              url : "cart.logic.php",
              method : "POST",
              data : {update_cart:1,product_id:pid,product_price:price,product_qty:qty},
              success : function(data){
                if(data.includes("LOGIN")) {
                  window.location.href='index.php?page=account';
                } else {
                  window.location.href='index.php?page=cart';
                }
              }
            });
          }
        });        
      });      

      $("body").delegate(".remove","click", function(event){
        var pid = $(this).attr('pid');
        var rid = $(this).attr('rowid');
        $.ajax({
          url : "product.logic.php",
          method : "POST",
          data : {remove_from_wishlist:1,product_id:pid},
          success : function(data){
            $('#row'+rid).remove();
            $('#message_div').html(data);
          }
        });
      });

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

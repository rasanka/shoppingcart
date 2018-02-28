  <!-- Start header section -->
  <header id="aa-header">
    <!-- start header top  -->
    <div class="aa-header-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-top-area">
              <!-- start header top left -->
              <div class="aa-header-top-left">

                <?php if(isset($_SESSION['sitid'])) {?>  
                  <div class="aa-login">
                    <div class="dropdown">
                      <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="glyphicon glyphicon-user"></span> Hi, <?php echo $_SESSION['situser']; ?>
                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="index.php?page=change_pwd"><span class="glyphicon glyphicon-wrench"></span> Change Password</a></li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
                      </ul>
                    </div>
                  </div>
                <?php } ?>

                <!-- start language -->
                <div class="aa-language">
                  <div class="dropdown">
                    <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      <img src="img/flag/english.jpg" alt="english flag">ENGLISH
                    </a>
                  </div>
                </div>
                <!-- / language -->

                <!-- start currency -->
                <div class="aa-currency">
                  <div class="dropdown">
                    <a class="btn dropdown-toggle" href="#">
                      <i class="fa fa-usd"></i>NZD
                    </a>
                  </div>
                </div>
                <!-- / currency -->
                <!-- start cellphone -->
                <div class="cellphone hidden-xs">
                  <p><span class="fa fa-phone"></span>021 164 6511</p>
                </div>
                <!-- / cellphone -->
              </div>
              <!-- / header top left -->
              <div class="aa-header-top-right">
                <ul class="aa-head-top-nav-right">

                  <?php if(isset($_SESSION['sitid'])) {?> 
                    <li class="hidden-xs"><a href="index.php?page=wishlist">Wishlist</a></li>
                    <li class="hidden-xs"><a href="index.php?page=cart">My Cart</a></li>
                    <li class="hidden-xs"><a href="index.php?page=checkout">Checkout</a></li>
                    <li class="hidden-xs"><a href="index.php?page=orders">My Orders</a></li>

                  <?php } else {?>  
                    <li><a href="index.php?page=account">Sign Up</a></li>
                    <li><a href="" data-toggle="modal" data-target="#login-modal">Sign In</a></li>
                  <?php } ?>

                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header top  -->

    <!-- start header bottom  -->
    <div class="aa-header-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
          	
            <!-- logo  -->
            <div class="aa-logo"><a href="index.php?page=home"><img src="img/logo_new.jpg" width="280" height="54" alt="PhoneRepairParts"/></a></div>
            <!-- / logo  -->
            
          </div>
          <div class="col-md-8">
            <div class="aa-header-bottom-area">        

              <!-- cart box -->
              <div class="aa-cartbox">
                <a class="aa-cart-link" href="index.php?page=cart">
                  <span class="fa fa-shopping-basket"></span>
                  <span class="aa-cart-title">SHOPPING CART</span>

                  <?php
                    $cart_qty = 0;
                    if(isset($_SESSION['sitcart'])) {
                    	require_once("cart.class.php");
	                    $cartObj = new Cart();

		    		    $cart_id = $_SESSION['sitcart'];
						$cart = $cartObj -> getIncompleteCartQty($cart_id);
						$cart_qty = $cart['qty_count'];
	
						if($cart_qty == "" || $cart_qty == null) {
							$cart_qty = 0;
						}
                    } 
                  ?>

                  <span class="aa-cart-notify"><?php echo $cart_qty; ?></span>
                </a>
                <div class="aa-cartbox-summary">
 
                </div>
              </div>
              <!-- / cart box -->

              <!-- search box  -->
              <div class="aa-search-box">

                  <input type="text" name="search_text" id="search_text" placeholder="Search here " onKeyPress="searchKeyPress(event);">
                  <button class="search-button" type="submit"><span class="fa fa-search"></span></button>

              </div>
              <!-- / search box -->             
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header bottom  -->
  </header>
  <!-- / header section -->

  <script src="js/jquery.min.js"></script>
<script type="text/javascript">

    function searchKeyPress(e){
      if (window.event) { e = window.event; }
      if (e.keyCode == 13){
        //validateLogin();
        var searchText = $('#search_text').val();
        if(searchText != "") {
          window.location.href='index.php?page=search&keyword='+searchText;
        }  
      }
    } 

  $(document).ready(function() {   

    $("body").delegate(".search-button","click", function(event){
      
      var searchText = $('#search_text').val();
      if(searchText != "") {
        window.location.href='index.php?page=search&keyword='+searchText;
      }            
    });     

    $("body").delegate(".aa-cart-link","mouseover", function(event){
      $.ajax({
        url : "cart.logic.php",
        method : "POST",
        data : {load_cart_items:1},
        success : function(data){
          $('.aa-cartbox-summary').html(data);
        }
      });
    }); 

    $("body").delegate(".aa-remove-product","click", function(event){
      var rid = $(this).attr('rowid');
      var pid = $(this).attr('pid');
      $.ajax({
        url : "cart.logic.php",
        method : "POST",
        data : {remove_item:1,product_id:pid},
        success : function(data){
          $('#row'+rid).remove();

          var qty = data.substr(0, data.indexOf('@'));
          var total = data.substr(data.indexOf('@')+1, data.length);
          $('.aa-cart-notify').html(qty);
          $('.aa-cartbox-total-price').html('$'+total);
        }
      });      
    }); 
    
  });

</script>
	
<?php require_once("menu.php"); ?> 	
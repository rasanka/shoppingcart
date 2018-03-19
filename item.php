  <?php

    require_once("item.class.php");
  
    $itemObj = new Item();

    $pid = $_GET['pid'];

    $details = array();
    $details = $itemObj -> loadItemByID($pid);

    $prod_image = $itemObj -> loadMainItemImage($pid);

    $image_path = "item_images/".$pid."/".$prod_image['image_name'];

  ?>    
    
    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Item</li>
            </ol>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4><?php echo strtoupper($details['item_name']); ?></h4>
          </div>
          <!-- end col-4 -->
        </div>
      </div>
    </section>

  <!-- catg header banner section
  <section id="aa-catg-head-banner">
   <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>T-Shirt</h2>
        <ol class="breadcrumb">
          <li><a href="index.html">Home</a></li>         
          <li><a href="#">Product</a></li>
          <li class="active">T-shirt</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
   / catg header banner section -->    

  <!-- product category -->
  <section id="aa-product-details">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-product-details-area">

            <div class="col-md-12" id="message_div">
              <!-- Message -->
            </div>

            <div class="aa-product-details-content">
              <div class="row">
                <!-- Modal view slider -->
                <div class="col-md-5 col-sm-5 col-xs-12">                              
                  <div class="aa-product-view-slider">                                
                    <div id="demo-1" class="simpleLens-gallery-container">
                      <div class="simpleLens-container">
                        <div class="simpleLens-big-image-container">
                        <a><img src="<?php echo $image_path; ?>" class="simpleLens-big-image"></a>
                        </div>
                      </div>
                      <div class="simpleLens-thumbnails-container">

                      <?php

                          $img_array = array();

                          $img_array = $itemObj ->  loadItemImagesByID($pid);
                                            
                          if(count($img_array) > 0){

                            $j = 0;
                            $itemCount = 1;
                            
                            while($j < (count($img_array)/2)){

                              echo "
                                    <a data-big-image='item_images/".$pid."/".$img_array['image_name'.$itemCount]."'
                                      class='simpleLens-thumbnail-wrapper' href='#'>
                                      <img width='45' height='55' src='item_images/".$pid."/".$img_array['image_name'.$itemCount]."'>
                                    </a>               
                              ";

                              $itemCount += 1;
                              $j +=1;
                            }

                          }

                      ?>                                                     
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal view content -->
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <div class="aa-product-view-content">
                    <h3><?php echo $details['prod_name']; ?></h3>
                    <div class="aa-price-block">
                      <span class="aa-product-view-price">$<?php echo $details['item_price']; ?></span>
                      <p class="aa-product-avilability">Avilability: <span>In stock</span></p>
                    </div>
                    <p><?php echo $details['short_desc']; ?></p>
                    <div class="aa-prod-quantity">
                      <form action="">
                        <select id="product_qty" name="product_qty">
                          <option selected="1" value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                          <option value="6">6</option>
                        </select>
                      </form>
                      
                    </div>
                    <div class="aa-prod-view-bottom">
                      <a class="aa-add-to-cart-btn" pid='<?php echo $pid; ?>' pprice='<?php echo $details['item_price']; ?>' href="#">Add To Cart</a>
                      <a class="aa-add-to-wish-btn" pid='<?php echo $pid; ?>' href="#">Wishlist</a>
                      <!--<a class="aa-add-to-cart-btn" href="#">Compare</a>-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="aa-product-details-bottom">
              <ul class="nav nav-tabs" id="myTab2">
                <li><a href="#description" data-toggle="tab">Description</a></li>
                <li><a href="#review" data-toggle="tab">Reviews</a></li>                
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane fade in active" id="description">
                  <?php echo $details['item_desc']; ?>
                </div>
                <div class="tab-pane fade " id="review">

                <?php

                  require_once("review.class.php");

                  $reviewObj = new Review();

                  $review_array = array();
                  $review_array = $reviewObj -> loadReviewsByProdId($pid);
                  $no_of_reviews = 0;

                  $reviews_html = "";
                  if(count($review_array) > 1) {

                    $r = 0;
                    $revCount = 1;

                    $no_of_reviews = (count($review_array)/6);
                    while($r < $no_of_reviews) {

                      $rating_int = $review_array['rating'.$revCount];
                      $rating_stars = "";
                      if($rating_int == 0) {
                        $rating_stars .= "<span class='fa fa-star'></span>";
                      }
                      for($q=1;$q<=$rating_int;$q++) {
                        $rating_stars .= "<span class='fa fa-star'></span>";
                      }
                      for($q=1;$q<=5-$rating_int;$q++) {
                        $rating_stars .= "<span class='fa fa-star-o'></span>";
                      }

                      $reviews_html .= "
                        <li>
                            <div class='media'>
                              <div class='media-left'>
                                <a href='index.php?page=item&pid=".$pid."'>
                                  <img class='media-object' src='".$image_path."'>
                                </a>
                              </div>
                              <div class='media-body'>
                                <h4 class='media-heading'><strong>".$review_array['name'.$revCount]."</strong> - <span>".$review_array['review_date'.$revCount]."</span></h4>
                                <div class='aa-product-rating'>
                                  ".$rating_stars."
                                </div>
                                <p>".$review_array['review'.$revCount]."</p>
                              </div>
                            </div>
                          </li>                                            
                      ";
                      $revCount += 1; 
                      $r +=1;
                    }

                  } else {
                    $reviews_html = "No Reviews available for this product.";
                  }

                ?>

                 <div class="aa-product-review-area">
                   <h4><?php echo $no_of_reviews; ?> Reviews for <?php echo $details['item_name']; ?></h4> 
                   <ul class="aa-review-nav">

                      <?php echo $reviews_html; ?>

                   </ul>
                   <h4>Add a review</h4>
                    <div class="col-md-12" id="review_message_div">
                      <!-- Message -->
                    </div>

                   <div class="aa-your-rating">
                     <p>Your Rating</p>
                     <span id="prod_rating1" value="1" class="fa fa-star-o"></span>
                     <span id="prod_rating2" value="2" class="fa fa-star-o"></span>
                     <span id="prod_rating3" value="3" class="fa fa-star-o"></span>
                     <span id="prod_rating4" value="4" class="fa fa-star-o"></span>
                     <span id="prod_rating5" value="5" class="fa fa-star-o"></span>
                   </div>
                   <!-- review form -->
                   <form id="reviewForm" action="POST" class="aa-review-form">
                      <div class="form-group">
                        <label  for="review_msg" class="control-label">Your Review</label>
                        <textarea class="form-control" rows="3"  id="review_msg" name="review_msg"></textarea>
                      </div>
                      <div class="form-group">
                        <label for="reviewer_name" class="control-label">Name</label>
                        <input type="text" class="form-control" id="reviewer_name" name="reviewer_name" placeholder="Name">
                      </div>  
                      <div class="form-group">
                        <label for="reviewer_email" class="control-label">Email</label>
                        <input type="email" class="form-control" id="reviewer_email" name="reviewer_email" placeholder="example@gmail.com">
                      </div>
                      <input type="hidden" id="hid_ratings" name="hid_ratings" value="0">
                      <input type="hidden" id="hid_prod_id" name="hid_prod_id" value="<?php echo $pid; ?>">
                      <button type="submit" class="btn btn-default aa-review-submit">Submit</button>
                   </form>
                 </div>
                </div>            
              </div>
            </div>

            <!-- Related product -->
            <div class="aa-product-related-item">

            <div class="col-md-12" id="related_message_div">
              <!-- Message -->
            </div>

              <h3>Related Products</h3>
              <ul class="aa-product-catg aa-related-item-slider">


              <?php
                //require_once("product.class.php");
    
                //$prodObj = new Product();

                $popular_products_html = "";
                $products = array();
                $products = $itemObj -> loadLatestItems();    
                
                if(count($products) > 1) {

                  $i = 0;
                  $rowCount = 1;

                            
                  while($i < (count($products)/11)){

                    $prod_id = $products['item_id'.$rowCount];
                    $ref_id = $products['ref_id'.$rowCount];
                    $prod_image = $itemObj -> loadMainItemImage($prod_id);
                            
                    $popular_products_html = $popular_products_html."
                        <li>
                            <figure>
                                <a class='aa-product-img' href='index.php?page=item&pid=".$prod_id."'><img width='250' height='300' src='item_images/".$prod_id."/".$prod_image['image_name']."' alt='".$products['item_name'.$rowCount]."'></a>
                                <a class='aa-add-card-btn' pid='".$item_id."' pprice='".$products['item_price'.$rowCount]."' href='#'><span class='fa fa-shopping-cart'></span>Add To Cart</a>
                                <figcaption>
                                    <h4 class='aa-product-title'><a href='index.php?page=item&pid=".$item_id."'>".$products['item_name'.$rowCount]."</a></h4>
                                    <span class='aa-product-price'>$".$products['item_price'.$rowCount]."</span><span class='aa-product-price'><del>$".$products['item_price'.$rowCount]."</del></span>
                                </figcaption>
                            </figure>                        
                            <div class='aa-product-hvr-content'>
                                <a href='#' class='add-to-wishlist' pid='".$prod_id."' data-toggle='tooltip' data-placement='top' title='Add to Wishlist'><span class='fa fa-heart-o'></span></a>                            
                                <a href='#' class='product-quick-view' pid='".$prod_id."' data-toggle2='tooltip' data-placement='top' title='Quick View' data-toggle='modal' data-target='#quick-view-modal'><span class='fa fa-search'></span></a>             
                            </div>
                            <span class='aa-badge aa-".strtolower($products['badge'.$rowCount])."' href='#'>".$products['badge'.$rowCount]."!</span>
                        </li>                      
                    ";                        

                    $rowCount += 1; 
                    $i +=1;
                }    
              } else {
                $popular_products_html = "No Products available!";
              }

              echo $popular_products_html;

              ?>


              </ul>
              <!-- quick view modal -->                  
              <div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              </div>
              <!-- / quick view modal -->   
            </div>  
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / product category -->

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrapValidator.min.js"></script>
  <script type="text/javascript">
    
    $(document).ready(function() {

      $("span[id^='prod_rating']").click(function() {
        var rating = $(this).attr('value');
        if($(this).hasClass("fa fa-star")) {
          $(this).removeClass('fa fa-star').addClass('fa fa-star-o');
          rating -= 1;
        }
        
        for(var i=1; i <= rating; i++){
          $("span[id^='prod_rating"+i+"']").removeClass('fa fa-star-o').addClass('fa fa-star');
        }  
        $("#hid_ratings").val(i-1);
      });

    $('#reviewForm').bootstrapValidator({
        fields: {
          review_msg: {
            validators: {
              notEmpty: {
                message: 'The review message is required and cannot be empty'
              }
            }
          },    
          reviewer_name: {
            validators: {
              notEmpty: {
                message: 'The name is required and cannot be empty'
              }
            }
          },                  
          reviewer_email: {
            validators: {
              notEmpty: {
                message: 'The email address is required'
              },
              emailAddress: {
                message: 'The input is not a valid email address'
              }
            }
          },			
        },        
        submitHandler: function(validator, form, submitButton) {
          $.ajax({
            url : "review.logic.php?check=saveReview",
            method : "POST",
            data : $("form").serialize(),
            success : function(data){
              $('#review_message_div').html(data);

              $("span[id^='prod_rating']").each(function() {
                $(this).removeClass('fa fa-star').addClass('fa fa-star-o');
              });               
              $('#review_msg').val('');
              $('#reviewer_name').val('');
              $('#reviewer_email').val('');
            }
          });
        }
      });
      
      $("body").delegate(".product-quick-view","click", function(event){
        event.preventDefault();
        var pid = $(this).attr('pid');
        $.ajax({
          url : "product.logic.php",
          method : "POST",
          data : {product_quick_view:1,product_id:pid},
          success : function(data){
            $('#quick-view-modal').html(data);
          }
        });
      });    

      $("body").delegate(".add-to-wishlist","click", function(event){
        event.preventDefault();
        var pid = $(this).attr('pid');
        $.ajax({
          url : "product.logic.php",
          method : "POST",
          data : {add_to_wishlist:1,product_id:pid},
          success : function(data){
            if(data.includes("LOGIN")) {
              window.location.href='index.php?page=account';
            } else {
              $('#related_message_div').html(data);
            }
          }
        });
      });   
        
      // Category view add to cart handling
      $("body").delegate(".aa-add-card-btn","click", function(event){
        event.preventDefault();
        var pid = $(this).attr('pid');
        var price = $(this).attr('pprice');
        $.ajax({
          url : "cart.logic.php",
          method : "POST",
          data : {add_to_cart:1,product_id:pid,product_price:price},
          success : function(data){
            if(data.includes("LOGIN")) {
              window.location.href='index.php?page=account';
            } else {
              $('#related_message_div').html(data);
              
              $.ajax({
                url : "cart.logic.php",
                method : "POST",
                data : {get_cart_qty:1},
                success : function(data){
                  $('.aa-cart-notify').html(data);
                }
              });
            
            }
          }
        });
      });         

      // Quick View add to cart handling
      $("body").delegate(".aa-add-to-cart-btn","click", function(event){
        event.preventDefault();
        var pid = $(this).attr('pid');
        var price = $(this).attr('pprice');
        var qty = $('#product_qty').val();
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
      });                 
   
    });

  </script>
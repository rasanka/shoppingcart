  <!-- Start slider -->
  <section id="aa-slider">
    <div class="aa-slider-area">
      <div id="sequence" class="seq">
         <ul class="seq-canvas">
            <!-- single slide item -->
            <li>
              <div class="seq-model">
                <img data-seq src="img/slider/1.jpg" alt="Men slide img" />
              </div>
              <div class="seq-title">
               <span data-seq>Save Up to 75% Off</span>                
                <h2 data-seq>Laptops</h2>                
                <p data-seq>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, illum.</p>
                <a data-seq href="index.php?page=category" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
              </div>
            </li>
            <!-- single slide item -->
            <li>
              <div class="seq-model">
                <img data-seq src="img/slider/2.jpg" alt="Wristwatch slide img" />
              </div>
              <div class="seq-title">
                <span data-seq>Save Up to 40% Off</span>                
                <h2 data-seq>Desktops</h2>                
                <p data-seq>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, illum.</p>
                <a data-seq href="index.php?page=category" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
              </div>
            </li>
            <!-- single slide item -->
            <li>
              <div class="seq-model">
                <img data-seq src="img/slider/3.jpg" alt="Women Jeans slide img" />
              </div>
              <div class="seq-title">
                <span data-seq>Save Up to 75% Off</span>                
                <h2 data-seq>Monitors</h2>                
                <p data-seq>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, illum.</p>
                <a data-seq href="index.php?page=category" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
              </div>
            </li>
            <!-- single slide item -->           
            <li>
              <div class="seq-model">
                <img data-seq src="img/slider/4.jpg" alt="Shoes slide img" />
              </div>
              <div class="seq-title">
                <span data-seq>Save Up to 75% Off</span>                
                <h2 data-seq>Keyboard & Mouse</h2>                
                <p data-seq>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, illum.</p>
                <a data-seq href="index.php?page=category" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
              </div>
            </li>
            <!-- single slide item -->  
             <li>
              <div class="seq-model">
                <img data-seq src="img/slider/5.jpg" alt="Male Female slide img" />
              </div>
              <div class="seq-title">
                <span data-seq>Save Up to 50% Off</span>                
                <h2 data-seq>Other Accessories</h2>                
                <p data-seq>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, illum.</p>
                <a data-seq href="index.php?page=category" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
              </div>
            </li>                   
          </ul>
        <!-- slider navigation btn -->

        <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
          <a type="button" class="seq-prev" aria-label="Previous"><span class="fa fa-angle-left"></span></a>
          <a type="button" class="seq-next" aria-label="Next"><span class="fa fa-angle-right"></span></a>
        </fieldset>

      </div>
    </div>
  </section>
  <!-- / slider -->
   
  <!-- Products section -->
  <section id="aa-product">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

            <div class="col-md-12" id="message_div">
              <!-- Message -->
            </div>

          <div class="row">
            <div class="aa-product-area">
              <div class="aa-product-inner">
                  <!-- start prduct navigation -->
                  <ul class="nav nav-tabs aa-products-tab">

                  <?php
                    require_once("category.class.php");
                    
                    $categoryObj = new Category();
                    
                    $categories = array();
                    $categories = $categoryObj -> loadCategories();

                    $heading = "";
                        
                    $i = 0;
                    $rowCount = 1;

                    while($i < (count($categories)/2)){

                      $active_tab = "";
                      if($rowCount == 1) {
                        $active_tab = " class='active'";
                      }  
                      $hash = "#";
                      $heading = $heading."<li".$active_tab."><a href='".$hash.preg_replace('/\s+/', '', strtolower($categories['cat_name'.$rowCount]))."' data-toggle='tab'>".strtoupper($categories['cat_name'.$rowCount])."</a></li>";

                      $rowCount += 1; 
                      $i +=1;
                    }
                    echo $heading;
                  ?>
                                    
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
  
                      <?php

                        require_once("product.class.php");
                        require_once("category.class.php");
                        
                        $prodObj = new Product();
                        $categoryObj = new Category();
                                          
                        $categories = array();
                        $categories = $categoryObj -> loadCategories();


                        $j = 0;
                        $catCount = 1;

                        while($j < (count($categories)/2)){

                          $active_tab = "";
                          if($catCount == 1) {
                            $active_tab = " in active";
                          }                            

                          $tab_pane = "
                            <div class='tab-pane fade".$active_tab."' id='".preg_replace('/\s+/', '', strtolower($categories['cat_name'.$catCount]))."'>
                              <ul class='aa-product-catg'> 
                          ";

                          $products = array();
                          $products = $prodObj -> loadProductsByCategory($categories['cat_id'.$catCount]);    

                          $prod_html = "";
                          if(count($products) > 1) {    
                            $i = 0;
                            $rowCount = 1;

                            
                            while($i < (count($products)/5)){

                              $prod_id = $products['prod_id'.$rowCount];
                              $ref_id = $products['ref_id'.$rowCount];
							                $cat_id = $products['prod_cat'.$rowCount];
							                $brand_id = $products['prod_brand'.$rowCount];
                              //$prod_image = $prodObj -> loadMainProductImage($prod_id);
                              $prod_html = $prod_html."                                                  
                                    <li>
                                      <figure>
                                        <a class='aa-product-img' href='index.php?page=category&cat_id=".$cat_id."&brand_id=".$brand_id."&prod_id=".$prod_id."'><img width='250' height='300' src='product_images/".$prod_id."/".$prod_id."_1.jpg' alt='".$products['prod_name'.$rowCount]."'></a>
                                        
                                          <figcaption>
                                          <h4 class='aa-product-title'><a href='index.php?page=category&cat_id=".$cat_id."&brand_id=".$brand_id."&prod_id=".$prod_id."'>".$products['prod_name'.$rowCount]."</a></h4>
                                          
                                        </figcaption>
                                      </figure>                        
                                      
                                    </li>                      
                              ";                        

                              $rowCount += 1; 
                              $i +=1;
                            }    
                          }              
                          
                          $tab_end = "
                              </ul>
                              <a class='aa-browse-btn' href='index.php?page=category&cat_id=".$categories['cat_id'.$catCount]."'>Browse all Product <span class='fa fa-long-arrow-right'></span></a>
                            </div>                         
                          ";

                          echo $tab_pane.$prod_html.$tab_end;

                          $catCount += 1; 
                          $j +=1;
                        }                        

                      ?>

                  </div>
                  <!-- / tab pane -->

                  <!-- quick view modal -->                  
                  <div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  </div><!-- / quick view modal -->              
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Products section -->


  
  <!-- banner section -->
  <section id="aa-banner">
    <div class="container">
      <div class="row">
        <div class="col-md-12">        
          <div class="row">
            <div class="aa-banner-area">
            <a href="#"><img src="img/fashion-banner.jpg" alt="fashion banner img"></a>
          </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <!-- popular section -->
  <section id="aa-popular-category">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-popular-category-area">
              <!-- start prduct navigation -->
             <ul class="nav nav-tabs aa-products-tab">
                <li class="active"><a href="#popular" data-toggle="tab">Popular</a></li>
                <li><a href="#featured" data-toggle="tab">Featured</a></li>
                <li><a href="#latest" data-toggle="tab">Latest</a></li>                    
              </ul>

              <?php
                require_once("item.class.php");
    
                $prodObj = new Item();

                $popular_products_html = "";
                $products = array();
                $products = $prodObj -> loadLatestItems();    
                
                if(count($products) > 1) {

                  $i = 0;
                  $rowCount = 1;

                            
                  while($i < (count($products)/12)){

                    $prod_id = $products['item_id'.$rowCount];
                    $ref_id = $products['ref_id'.$rowCount];
                    $prod_image = $prodObj -> loadMainItemImage($prod_id);
                            
                    $price_line = "";
                    if($products['item_discount_price'.$rowCount] > 0) {
                      $price_line = "<span class='aa-product-price'>$".$products['item_price'.$rowCount]."</span><span class='aa-product-price'><del>$".$products['item_discount_price'.$rowCount]."</del></span>";
                    } else {
                      $price_line = "<span class='aa-product-price'>$".$products['item_price'.$rowCount]."</span>";
                    }
                    $popular_products_html = $popular_products_html."
                        <li>
                            <figure>
                                <a class='aa-product-img' href='index.php?page=item&pid=".$prod_id."'><img width='250' height='300' src='item_images/".$prod_id."/".$prod_image['image_name']."' alt='".$products['item_name'.$rowCount]."'></a>
                                <a class='aa-add-card-btn' pid='".$prod_id."' pprice='".$products['item_price'.$rowCount]."' href='#'><span class='fa fa-shopping-cart'></span>Add To Cart</a>
                                <figcaption>
                                    <h4 class='aa-product-title'><a href='index.php?page=item&pid=".$prod_id."'>".$products['item_name'.$rowCount]."</a></h4>
                                    ".$price_line."
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
			  
                $featured_products_html = "";
                $products = array();
                $products = $prodObj -> loadTopRatedItems();    
                
                if(count($products) > 1) {

                  $i = 0;
                  $rowCount = 1;

                            
                  while($i < (count($products)/12)){

                    $prod_id = $products['item_id'.$rowCount];
                    $ref_id = $products['ref_id'.$rowCount];
                    $prod_image = $prodObj -> loadMainItemImage($prod_id);
                            
                    $price_line = "";
                    if($products['item_discount_price'.$rowCount] > 0) {
                      $price_line = "<span class='aa-product-price'>$".$products['item_price'.$rowCount]."</span><span class='aa-product-price'><del>$".$products['item_discount_price'.$rowCount]."</del></span>";
                    } else {
                      $price_line = "<span class='aa-product-price'>$".$products['item_price'.$rowCount]."</span>";
                    }
                    $featured_products_html = $featured_products_html."
                        <li>
                            <figure>
                                <a class='aa-product-img' href='index.php?page=item&pid=".$prod_id."'><img width='250' height='300' src='item_images/".$prod_id."/".$prod_image['image_name']."' alt='".$products['item_name'.$rowCount]."'></a>
                                <a class='aa-add-card-btn' pid='".$prod_id."' pprice='".$products['item_price'.$rowCount]."' href='#'><span class='fa fa-shopping-cart'></span>Add To Cart</a>
                                <figcaption>
                                    <h4 class='aa-product-title'><a href='index.php?page=item&pid=".$prod_id."'>".$products['item_name'.$rowCount]."</a></h4>
                                    ".$price_line."
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
                $featured_products_html = "No Products available!";
              }

                $latest_products_html = "";
                $products = array();
                $products = $prodObj -> loadLatestItems();    
                
                if(count($products) > 1) {

                  $i = 0;
                  $rowCount = 1;

                            
                  while($i < (count($products)/12)){

                    $prod_id = $products['item_id'.$rowCount];
                    $ref_id = $products['ref_id'.$rowCount];
                    $prod_image = $prodObj -> loadMainItemImage($prod_id);
                            
                    $price_line = "";
                    if($products['item_discount_price'.$rowCount] > 0) {
                      $price_line = "<span class='aa-product-price'>$".$products['item_price'.$rowCount]."</span><span class='aa-product-price'><del>$".$products['item_discount_price'.$rowCount]."</del></span>";
                    } else {
                      $price_line = "<span class='aa-product-price'>$".$products['item_price'.$rowCount]."</span>";
                    }                    
                    $latest_products_html = $latest_products_html."
                        <li>
                            <figure>
                                <a class='aa-product-img' href='index.php?page=item&pid=".$prod_id."'><img width='250' height='300' src='item_images/".$prod_id."/".$prod_image['image_name']."' alt='".$products['item_name'.$rowCount]."'></a>
                                <a class='aa-add-card-btn' pid='".$prod_id."' pprice='".$products['item_price'.$rowCount]."' href='#'><span class='fa fa-shopping-cart'></span>Add To Cart</a>
                                <figcaption>
                                    <h4 class='aa-product-title'><a href='index.php?page=item&pid=".$prod_id."'>".$products['item_name'.$rowCount]."</a></h4>
                                    ".$price_line."
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
                $latest_products_html = "No Products available!";
              }			  
                          
              ?> 


              <!-- Tab panes -->
              <div class="tab-content">
                <!-- Start men popular category -->
                <div class="tab-pane fade in active" id="popular">
                  <ul class="aa-product-catg aa-popular-slider">
                    <?php echo $popular_products_html; ?>                                                                                 
                  </ul>
                  <a class="aa-browse-btn" href="index.php?page=category">Browse all Product <span class="fa fa-long-arrow-right"></span></a>
                </div>
                <!-- / popular product category -->
                
                <!-- start featured product category -->
                <div class="tab-pane fade" id="featured">
                  <ul class="aa-product-catg aa-featured-slider">
                    <?php echo $featured_products_html; ?>                                                                                     
                  </ul>
                  <a class="aa-browse-btn" href="index.php?page=category">Browse all Product <span class="fa fa-long-arrow-right"></span></a>
                </div>
                <!-- / featured product category -->

                <!-- start latest product category -->
                <div class="tab-pane fade" id="latest">
                  <ul class="aa-product-catg aa-latest-slider">
                    <?php echo $latest_products_html; ?>                                                                               
                  </ul>
                   <a class="aa-browse-btn" href="index.php?page=category">Browse all Product <span class="fa fa-long-arrow-right"></span></a>
                </div>
                <!-- / latest product category -->              
              </div>
            </div>
          </div> 
        </div>
      </div>
    </div>
  </section>
  <!-- / popular section -->
  
  <!-- Support section -->
  <section id="aa-support">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-support-area">
            <!-- single support -->
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="aa-support-single">
                <span class="fa fa-truck"></span>
                <h4>FREE DELIVERY</h4>
                <P>PhoneRepairParts.co.nz.com.au is a new way of delivering IT services to customers.</P>
              </div>
            </div>
            <!-- single support -->
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="aa-support-single">
                <span class="fa fa-clock-o"></span>
                <h4>GURANTEED SERVICE</h4>
                <P>We gurantee that you will get the best service all the time</P>
              </div>
            </div>
            <!-- single support -->
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="aa-support-single">
                <span class="fa fa-phone"></span>
                <h4>SUPPORT 24/7</h4>
                <P>Call us anytime for all your IT related matters. We are here to help you</P>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Support section -->
  
  <!-- Client Brand
  <section id="aa-client-brand">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-client-brand-area">
            <ul class="aa-client-brand-slider">
              <li><a href="#"><img src="img/client-brand-java.png" alt="java img"></a></li>
              <li><a href="#"><img src="img/client-brand-jquery.png" alt="jquery img"></a></li>
              <li><a href="#"><img src="img/client-brand-html5.png" alt="html5 img"></a></li>
              <li><a href="#"><img src="img/client-brand-css3.png" alt="css3 img"></a></li>
              <li><a href="#"><img src="img/client-brand-wordpress.png" alt="wordPress img"></a></li>
              <li><a href="#"><img src="img/client-brand-joomla.png" alt="joomla img"></a></li>
              <li><a href="#"><img src="img/client-brand-java.png" alt="java img"></a></li>
              <li><a href="#"><img src="img/client-brand-jquery.png" alt="jquery img"></a></li>
              <li><a href="#"><img src="img/client-brand-html5.png" alt="html5 img"></a></li>
              <li><a href="#"><img src="img/client-brand-css3.png" alt="css3 img"></a></li>
              <li><a href="#"><img src="img/client-brand-wordpress.png" alt="wordPress img"></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Client Brand -->
  
  <?php include("subscribe.php"); ?>

  <script src="js/jquery.min.js"></script>
  <script type="text/javascript">
    
    $(document).ready(function() {
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
              $('#message_div').html(data);
            }
          }
        });
      });   

      // Category view add to cart handling
      $("body").delegate(".aa-add-card-btn","click", function(event){
        event.preventDefault();
        var pid = $(this).attr('pid');
        var price = $(this).attr('pprice');
        //alert(pid);
        $.ajax({
          url : "cart.logic.php",
          method : "POST",
          data : {add_to_cart:1,product_id:pid,product_price:price},
          success : function(data){
            if(data.includes("LOGIN")) {
              window.location.href='index.php?page=account';
            } else {
              $('#message_div').html(data);
              
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
        //alert(pid);
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
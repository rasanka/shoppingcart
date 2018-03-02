    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Category</li>
            </ol>
          </div>
                <?php
                  require_once("product.class.php");
				  require_once("item.class.php");
				  require_once("category.class.php");
                
                  $productObj = new Product();
				  $itemObj = new Item();
				  $catObj = new Category();

                  $cat_id = (isset($_GET['cat_id']) ? $_GET['cat_id'] : 1);
                  $brand_id = (isset($_GET['brand_id']) ? $_GET['brand_id'] : 0);
				  $prod_id = (isset($_GET['prod_id']) ? $_GET['prod_id'] : 1);
                
                  $products_html = "";
                  $prod_array = array();
				  
				  $page_heading = '';
				  if(isset($_GET['prod_id'])){
					  $prod_array = $itemObj -> loadItemsByProduct($prod_id);
					  $prodData = $productObj -> loadProductByID($prod_id);
					  $page_heading = $prodData['prod_name'];
				  } else {
					  if(isset($_GET['brand_id'])){
						$prod_array = $productObj -> loadProductsByCategoryAndBrand($cat_id, $brand_id);
						$brandData = $catObj -> loadBrandByID($brand_id);
						$page_heading = $brandData['brand_name'];
					  } else {
						$prod_array = $productObj -> loadProductsByCategory($cat_id);
						$catData = $catObj -> loadCategoryByID($cat_id);
						$page_heading = $catData['cat_name'];
					  }
				  }
				?>          
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4><?php echo strtoupper($page_heading); ?></h4>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 hidden-xs"><span class="font-size"> <a href="#">-</a> <i class="fa fa-font"></i> <a href="#">+</a></span></div>
          <!-- end col-4 -->
        </div>
      </div>
    </section>  

  <!-- product category -->
  <section id="aa-product-category">
    <div class="container">
      <div class="row">

        <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
          <div class="aa-product-catg-content">
          
            <div class="col-md-12" id="message_div">
              <!-- Message -->
            </div>
				<?php
                  $j = 0;
                  $itemCount = 1;
                    
                  //while ($j < count($brands)) {
                  if(count($prod_array) > 1){ ?>


                  <div class="aa-product-catg-head">
                    <div class="aa-product-catg-head-left">
                      <form action="" class="aa-sort-form">
                        <label for="">Sort by</label>
                        <select name="">
                          <option value="1" selected="Default">Default</option>
                          <option value="2">Name</option>
                          <option value="3">Price</option>
                          <option value="4">Date</option>
                        </select>
                      </form>
                      <form action="" class="aa-show-form">
                        <label for="">Show</label>
                        <select name="">
                          <option value="1" selected="12">12</option>
                          <option value="2">24</option>
                          <option value="3">36</option>
                        </select>
                      </form>
                    </div>
                    <div class="aa-product-catg-head-right">
                      <a id="grid-catg" href="#"><span class="fa fa-th"></span></a>
                      <a id="list-catg" href="#"><span class="fa fa-list"></span></a>
                    </div>
                  </div>

                  <div class="aa-product-catg-body">
                    <ul class="aa-product-catg">


                    <?php
					
					if(isset($_GET['prod_id'])){
						
						// ITEMS-------------------------------------------				
						while($j < (count($prod_array)/11)){
	
						  $prod_image = $itemObj -> loadMainItemImage($prod_array['item_id'.$itemCount]);
	
						  // <p class='aa-product-descrip'>".$prod_array['product_desc'.$itemCount]."</p>        
						  $products_html = $products_html." 
							<li>
							  <figure>
								<a class='aa-product-img' href='index.php?page=item&pid=".$prod_array['item_id'.$itemCount]."'><img width='250' height='300' src='item_images/".$prod_array['ref_id'.$itemCount]."/".$prod_image['image_name']."' alt='".$prod_array['item_name'.$itemCount]."'></a>
								<a class='aa-add-card-btn' pid='".$prod_array['item_id'.$itemCount]."' pprice='".$prod_array['item_price'.$itemCount]."' href='#'><span class='fa fa-shopping-cart'></span>Add To Cart</a>
								<figcaption>
								  <h4 class='aa-product-title'><a href='index.php?page=item&pid=".$prod_array['item_id'.$itemCount]."'>".$prod_array['item_name'.$itemCount]."</a></h4>
								  <span class='aa-product-price'>$".$prod_array['item_price'.$itemCount]."</span><span class='aa-product-price'><del>$".$prod_array['item_price'.$itemCount]."</del></span>                                                    
								</figcaption>
							  </figure>                         
							  <div class='aa-product-hvr-content'>
								<a href='#' class='add-to-wishlist' pid='".$prod_array['item_id'.$itemCount]."' data-toggle='tooltip' data-placement='top' title='Add to Wishlist'><span class='fa fa-heart-o'></span></a>                            
								<a href='#' class='product-quick-view' pid='".$prod_array['item_id'.$itemCount]."' data-toggle2='tooltip' data-placement='top' title='Quick View' data-toggle='modal' data-target='#quick-view-modal'><span class='fa fa-search'></span></a>                            
							  </div>
							  <span class='aa-badge aa-".strtolower($prod_array['badge'.$itemCount])."' href='#'>".$prod_array['badge'.$itemCount]."!</span>
							</li> ";
	
						  $itemCount += 1;
						  $j +=1;
						}						
						
						
					} else {
					
						// PRODUCTS-------------------------------------------	
						while($j < (count($prod_array)/5)){
	
						  $prod_image = $productObj -> loadMainProductImage($prod_array['prod_id'.$itemCount]);
	
						  // <p class='aa-product-descrip'>".$prod_array['product_desc'.$itemCount]."</p>        
						  $products_html = $products_html." 
							<li>
							  <figure>
								<a class='aa-product-img' href='index.php?page=category&cat_id=".$cat_id."&brand_id=".$brand_id."&prod_id=".$prod_array['prod_id'.$itemCount]."'><img width='250' height='300' src='product_images/".$prod_array['prod_id'.$itemCount]."/".$prod_image['image_name']."' alt='".$prod_array['prod_name'.$itemCount]."'></a>
								
								<figcaption>
								  <h4 class='aa-product-title'><a href='index.php?page=category&cat_id=".$cat_id."&brand_id=".$brand_id."&prod_id=".$prod_array['prod_id'.$itemCount]."'>".$prod_array['prod_name'.$itemCount]."</a></h4>
								                                                    
								</figcaption>
							  </figure>
							</li> ";
	
						  $itemCount += 1;
						  $j +=1;
						}
					
					}
                    echo $products_html;
              ?>

                </ul>
                <!-- quick view modal -->                  
                <div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                </div>
                <!-- / quick view modal -->   
              </div>


              <?php
                  } else {

                    echo "
                    <div class='alert alert-warning'>
		                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>No Products available in this category!</b>
	                  </div>";
                  }
              ?>              
                                                          

            <!--
            <div class="aa-product-catg-pagination">
              <nav>
                <ul class="pagination">
                  <li>
                    <a href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li>
                    <a href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
            -->
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
          <aside class="aa-sidebar">
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Brands</h3>
              <ul class="aa-catg-nav">

                <?php
                  require_once("category.class.php");
                
                  $categoryObj = new Category();
                

                  $brandNames = "";
                  $brands = array();
                  $brands = $categoryObj -> loadBrandsByCatId($cat_id);
                  $j = 0;
                  $itemCount = 1;
                    
                  //while ($j < count($brands)) {
                  while($j < (count($brands)/2)){
                    $brandNames = $brandNames."<li><a href='index.php?page=category&cat_id=".$cat_id."&brand_id=".$brands['brand_id'.$itemCount]."'>".ucfirst($brands['brand_name'.$itemCount])."</a></li>";
                    $itemCount += 1;
                    $j +=1;
                  }
                  echo $brandNames;
              ?>
              </ul>
            </div>
            <!-- single sidebar
            <div class="aa-sidebar-widget">
              <h3>Tags</h3>
              <div class="tag-cloud">
                <a href="#">Fashion</a>
                <a href="#">Ecommerce</a>
                <a href="#">Shop</a>
                <a href="#">Hand Bag</a>
                <a href="#">Laptop</a>
                <a href="#">Head Phone</a>
                <a href="#">Pen Drive</a>
              </div>
            </div> -->
            
            <!-- single sidebar          
            <script type="text/javascript" src="js/nouislider.js"></script>
            <div class="aa-sidebar-widget">
              <h3>Shop By Price</h3>              

              <div class="aa-sidebar-price-range">
               <form action="">
                  <div id="skipstep" class="noUi-target noUi-ltr noUi-horizontal noUi-background">
                  </div>
                  <span id="skip-value-lower" class="example-val">30.00</span>
                  <span id="skip-value-upper" class="example-val">100.00</span>
                 <button class="aa-filter-btn" type="submit">Filter</button>
               </form>
              </div>              

            </div>
            -->            
            
            <!-- single sidebar
            <div class="aa-sidebar-widget">
              <h3>Shop By Color</h3>
              <div class="aa-color-tag">
                <a class="aa-color-green" href="#"></a>
                <a class="aa-color-yellow" href="#"></a>
                <a class="aa-color-pink" href="#"></a>
                <a class="aa-color-purple" href="#"></a>
                <a class="aa-color-blue" href="#"></a>
                <a class="aa-color-orange" href="#"></a>
                <a class="aa-color-gray" href="#"></a>
                <a class="aa-color-black" href="#"></a>
                <a class="aa-color-white" href="#"></a>
                <a class="aa-color-cyan" href="#"></a>
                <a class="aa-color-olive" href="#"></a>
                <a class="aa-color-orchid" href="#"></a>
              </div>                            
            </div> -->
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Recently Views</h3>
              <div class="aa-recently-views">
                <ul>


                <?php
                  require_once("item.class.php");
      
                  $prodObj = new Item();

                  $popular_products_html = "";
                  $products = array();
                  $products = $prodObj -> loadLatestItems();    
                  
                  if(count($products) > 1) {

                    $i = 0;
                    $rowCount = 1;
                              
                    while($i < (count($products)/11)){

                      if($rowCount == 4) {
                        break;
                      }

                      $prod_id = $products['item_id'.$rowCount];
                      $ref_id = $products['ref_id'.$rowCount];
                      $prod_image = $prodObj -> loadMainItemImage($prod_id);
                              
                      echo "
                          <li>
                            <a href='index.php?page=product&pid=".$prod_id."' class='aa-cartbox-img'><img width='150' height='150' alt='img' src='item_images/".$ref_id."/".$prod_image['image_name']."'></a>
                            <div class='aa-cartbox-info'>
                              <h4><a href='index.php?page=product&pid=".$prod_id."'>".$products['item_name'.$rowCount]."</a></h4>
                              <p>1 x $".$products['item_price'.$rowCount]."</p>
                            </div>                    
                          </li>                          

                      ";                        

                      $rowCount += 1; 
                      $i +=1;
                  }    
                } 

                ?>
                                   
                </ul>
              </div>                            
            </div>
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Top Rated Products</h3>
              <div class="aa-recently-views">
                <ul>
                <?php
                  require_once("item.class.php");
      
                  $prodObj = new Item();

                  $popular_products_html = "";
                  $products = array();
                  $products = $prodObj -> loadTopRatedItems();    
                  
                  if(count($products) > 1) {

                    $i = 0;
                    $rowCount = 1;
                              
                    while($i < (count($products)/11)){

                      if($rowCount == 4) {
                        break;
                      }

                      $prod_id = $products['item_id'.$rowCount];
                      $ref_id = $products['ref_id'.$rowCount];
                      $prod_image = $prodObj -> loadMainItemImage($prod_id);
                              
                      echo "
                          <li>
                            <a href='index.php?page=item&pid=".$prod_id."' class='aa-cartbox-img'><img width='150' height='150' alt='img' src='item_images/".$ref_id."/".$prod_image['image_name']."'></a>
                            <div class='aa-cartbox-info'>
                              <h4><a href='index.php?page=item&pid=".$prod_id."'>".$products['item_name'.$rowCount]."</a></h4>
                              <p>1 x $".$products['item_price'.$rowCount]."</p>
                            </div>                    
                          </li>                          

                      ";                        

                      $rowCount += 1; 
                      $i +=1;
                  }    
                } 
                ?>                                    
                </ul>
              </div>                            
            </div>
          </aside>
        </div>
       
      </div>
    </div>
  </section>
  <!-- / product category -->

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
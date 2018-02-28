  <?php
  require_once("category.class.php");
  
  $categoryObj = new Category();
  
  $categories = array();
  $categories = $categoryObj -> loadCategories();

  $heading = "";
      
  $i = 0;
  $rowCount = 1;

  while($i < (count($categories)/2)){

    $heading = $heading."<li><a href='index.php?page=category&cat_id=".$categories['cat_id'.$rowCount]."'>".ucfirst($categories['cat_name'.$rowCount])."<span class='caret'></span></a>
      <ul class='dropdown-menu'>";

    $menuItem = "";
    $brands = array();
    $brands = $categoryObj -> loadBrandsByCatId($categories['cat_id'.$rowCount]);
    $j = 0;
    $itemCount = 1;
      
    while($j < (count($brands)/2)){

      $menuItem = $menuItem."<li><a href='index.php?page=category&cat_id=".$categories['cat_id'.$rowCount]."&brand_id=".$brands['brand_id'.$itemCount]."'>".ucfirst($brands['brand_name'.$itemCount])."</a></li>";
      $itemCount += 1;
      $j +=1;
    }

    $heading = $heading.$menuItem."</ul></li>";
    $rowCount += 1; 
    $i +=1;
  }

?>

  <!-- menu -->
  <section id="menu">
    <div class="container">
      <div class="menu-area">
        <!-- Navbar -->
        <div class="navbar navbar-default" role="navigation">

          <div class="navbar-collapse collapse">
            <!-- Left nav -->
            <ul class="nav navbar-nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="index.php?page=about">About Us</a></li>
              <?php echo $heading; ?> 
              <!--<li><a href="index.php?page=blog">Blog</a></li>-->
              <li><a href="index.php?page=contact">Contact Us</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>       
    </div>
  </section>
  <!-- / menu -->
  <?php 
  	if(!isset($_GET['page'])) {
		include("home.php");	
	} else if ($_GET['page'] == "register") {
		$email = $_GET["email"];
		include("register.php?email="+$email);	
	} else if ($_GET['page'] == "contact") {
		include("contact.php");	
	} else if ($_GET['page'] == "checkout") {
		include("checkout.php");	
	} else if ($_GET['page'] == "cart") {
		include("cart.php");	
	} else if ($_GET['page'] == "wishlist") {
		include("wishlist.php");	
	} else if ($_GET['page'] == "account") {
		include("account.php");	
	} else if ($_GET['page'] == "about") {
		include("about.php");	
	} else if ($_GET['page'] == "category") {
		include("category.php");	
	} else if ($_GET['page'] == "product") {
		include("product.php");	
	} else if ($_GET['page'] == "blog") {
		include("blog.php");	
	} else if ($_GET['page'] == "blog_detail") {
		include("blog_detail.php");	
	} else {
		include("404.php");
	}	
  ?>
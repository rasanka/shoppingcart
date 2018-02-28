<?php
	ob_start();
	include_once ("config/config.php");
	if($_SESSION["ses_user_name"] == null || $_SESSION["ses_user_name"] == "" || !isset($_SESSION["ses_user_name"])){
		session_destroy();
		header("Location:".$SERVER_URL."index.php");
		die();
	}

	if($_SESSION["ses_user_level"] == "DOCTOR" || $_SESSION["ses_user_level"] == "EDITOR"){ 
		header("Location:".$SERVER_URL."edit_user.php");
		die();
	}
	ob_end_flush();
?>
<html>
<head>
<title><?php echo $SYSTEM_NAME; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/ebees_1.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<link rel="stylesheet" href="css/ebees_2.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<link rel="stylesheet" href="css/cssverticalmenu.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<link rel="stylesheet" href="css/messages.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="css/notifications.css">
<link rel="stylesheet" type="text/css" href="css/uploadstyles.css" />

<script src="javascript/XMLHTTP.js" type="text/javascript" charset="utf-8"></script>	
<script src="javascript/common.js" type="text/javascript" charset="utf-8"></script>
<script src="javascript/cssverticalmenu.js" type="text/javascript" charset="utf-8"></script>
<script src="javascript/messages.js" type="text/javascript" charset="utf-8"></script>
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/jquery-1.3.2.js" ></script>
<script type="text/javascript" src="javascript/ajaxupload.3.5.js" ></script>

<script language="JavaScript" type="text/javascript">  

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function init(){
	var level = "<?php echo $_SESSION["ses_user_level"]; ?>";
	if(level == "ADMIN"){
        loadCategoryList();    
	}
}

function loadProductList(){
	var urlString = "product.logic.php";
	var http = getHTTPObject();
	http.open("POST", urlString , true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
                alert('return');
				document.getElementById("products_div").innerHTML = http.responseText;
			}else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send("chksql=loadProductList"); 		
}

function loadCategoryList(){
	var urlString = "category.logic.php?chksql=loadCategoryListForProduct";
	var http = getHTTPObject();
	http.open("GET", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				document.getElementById("categories_div").innerHTML = http.responseText;
                loadBrandListByCategory();
			}else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(null); 		
}

function loadBrandListByCategory(){
  var category = document.getElementById("categories").value;
	var urlString = "brand.logic.php?chksql=loadBrandListByCategory&cat_id="+category;
	var http = getHTTPObject();
	http.open("GET", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				document.getElementById("brands_div").innerHTML = http.responseText;
			}else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(null); 		
}

function deleteProduct(pid){
    //alert(pid);
	var product = pid;
	var result = confirm("Are You Sure! You want to delete this Product?");
	if(result){
		document.getElementById("delete_result").innerHTML = "<img src='images/loading.gif'>";
		var urlString = "product.logic.php";
		var parameters = "chksql=deleteProduct&id="+product;
		//alert(urlString);			
		var http = getHTTPObject();
		http.open("POST", urlString , true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		http.onreadystatechange = function() {
			if (http.readyState == 4){
				if (http.status == 200) {
					var result = http.responseText;
					document.getElementById("delete_result").innerHTML = "";
					if(result.indexOf("SUCCESS") > -1){
						document.getElementById("delete_result").style.color = "blue";
						document.getElementById("delete_result").innerHTML = "Product Deleted Successfully!";		
    					//init();					
					}else{
						document.getElementById("delete_result").style.color = "red";
						document.getElementById("delete_result").innerHTML = "Error Occured! Please try Again.";
					}
					//var t=setTimeout("resetPage()",3000);
				}
			}
		}
		http.send(parameters); 	
	}
}

function searchProducts(){
	var name = document.getElementById("name").value;
    var category = document.getElementById("categories").value;
	var brand = document.getElementById("brands").value;
    var ref_id = document.getElementById("ref_id").value;
	
	if(category == "-"){
		inlineMsg('categories','<strong>Error</strong><br />Please select the Category!',2);
    	status = false;
	} else if(brand == "-"){
		inlineMsg('brands','<strong>Error</strong><br />Please select the Brand!',2);
    	status = false;
	} else {		
		document.getElementById("product_list_div").innerHTML = "<img src='images/loading.gif'>";
		var urlString = "product.logic.php";
        var parameters = "chksql=searchProducts&name="+name+"&cat_id="+category+"&brand="+brand+"&ref_id="+ref_id;
		//alert(urlString);
		var http = getHTTPObject();
		http.open("POST", urlString , true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		http.onreadystatechange = function() {
			if (http.readyState == 4){
				if (http.status == 200) {
					var result = http.responseText;
					document.getElementById("search_result_div").style.display="inline";
					document.getElementById("product_list_div").innerHTML = "";
					document.getElementById("product_list_div").innerHTML = result;						
				} 
				else{
					alert("Error Occured : " + http.statusText);
				}
			}
		}
		http.send(parameters);				
	}
}

function resetPage(){
	document.location.reload();
}	

			
</script>
</head>				
				
<body onLoad="loadNewMenu(); init();">	
<input type="hidden" name="hid_member_id" id="hid_member_id" value="">
  <table width="1087" height="591" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="19" align="right" class="body">&nbsp;&nbsp;&nbsp;Logged 
        In : <?php echo $_SESSION["ses_name"];?> [<?php echo $_SESSION["ses_user_level"];?>]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr> 
      <td width="1087" height="572" valign="top" class="body"> 

        <fieldset class="fieldset">
        <table width="100%" height="591" border="0" cellpadding="0" cellspacing="0">    
          <tr>
            <td width="20%" valign="top"><?php require_once("menu.php"); ?></td> 
            <td width="80%" height="450" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
              <tr height="20">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="header_title" height="20">&nbsp;&nbsp;&nbsp;Backoffice Product Management</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="98%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
              </tr>
              <tr>
                <td><fieldset class="fieldset">
                <legend class="legend">Search Products</legend>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                  <tr>
                    <td width="4%">&nbsp;</td>
                    <td width="20%">&nbsp;</td>
                    <td width="20%">&nbsp;</td>
                    <td width="2%">&nbsp;</td>
                    <td width="20%">&nbsp;</td>
                    <td width="20%">&nbsp;</td>
                    <td width="4%">&nbsp;</td>
                  </tr>    

                  <tr>
                    <td>&nbsp;</td>
                    <td>Category</td>
                    <td><div id="categories_div"></div></td>
                    <td>&nbsp;</td>
                    <td>Brand</td>
                    <td><div id="brands_div"></div></td>
                    <td>&nbsp;</td>
                  </tr>       

                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>    

                  <tr>
                    <td>&nbsp;</td>
                    <td>Title</td>
                    <td><input name="name" type="text" class="body" id="name" size="20"></td>
                    <td>&nbsp;</td>
                    <td>Ref ID (SKU)</td>
                    <td><input type="text" name="ref_id" id="ref_id" class="body"></td>
                    <td>&nbsp;</td>
                  </tr>                                   

                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input type="button" name="submit2" id="submit2" value="Search Products" class="body" onClick="searchProducts();"></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                </fieldset>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>

              <tr>
                <td>
                <div id="search_result_div" style="display:none">
                <fieldset class="fieldset">
                <legend class="legend">Search Result</legend>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="98%">&nbsp;</td>
                    <td width="1%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><div id="product_list_div"></div></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                </fieldset>    
                </div>          
                </td>
                <td>&nbsp;</td>
              </tr>

            </table>            
            </td>
          </tr>
          <tr>
            <td height="20" colspan="2"><?php require_once("footer.php"); ?></td>
          </tr>
        </table>
        </fieldset></td>
    </tr>
  </table>
 
</body>
</html>


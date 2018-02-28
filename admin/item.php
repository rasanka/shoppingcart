<?php
	ob_start();
	include_once ("config/config.php");
	if($_SESSION["ses_user_name"] == null || $_SESSION["ses_user_name"] == "" || !isset($_SESSION["ses_user_name"])){
		session_destroy();
		header("Location:".$SERVER_URL."index.php");
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
		document.getElementById("name").value = "";
		loadProductList();    
		loadStatusList();
    	loadRatingList();
    	loadBadgeList();
	}
}

function loadProductList(){
	var urlString = "product.logic.php";
	var parameters = "chksql=loadProductList";
	
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				document.getElementById("products_div").innerHTML = http.responseText;
			}else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(parameters); 		
}

function loadRatingList(){
	document.getElementById("rating_select_div").innerHTML = "<img src='images/loading.gif'>";
	var urlString = "item.logic.php";
  var parameters = "chksql=loadRatingList";

	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				document.getElementById("rating_select_div").innerHTML = "";
				document.getElementById("rating_select_div").innerHTML = http.responseText;
			} else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(parameters); 	
}

function loadBadgeList(){
	document.getElementById("badge_select_div").innerHTML = "<img src='images/loading.gif'>";
	var urlString = "item.logic.php";
  var parameters = "chksql=loadBadgeList";

	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				document.getElementById("badge_select_div").innerHTML = "";
				document.getElementById("badge_select_div").innerHTML = http.responseText;
			} else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(parameters); 	
}

function loadStatusList(){
	document.getElementById("status_select_div").innerHTML = "<img src='images/loading.gif'>";
	var urlString = "item.logic.php";
  var parameters = "chksql=loadStatusList";

	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				document.getElementById("status_select_div").innerHTML = "";
				document.getElementById("status_select_div").innerHTML = http.responseText;
			} else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(parameters); 	
}
	
function validateEntry(){
	var name = document.getElementById("name").value;
    var product = document.getElementById("products").value;
	//var brand = document.getElementById("brands").value;
    var short_desc = document.getElementById("short_desc").value;
	var description = CKEDITOR.instances.description.getData();
	var price = document.getElementById("price").value;
	var stock = document.getElementById("stock").value;
	var ref_id = document.getElementById("ref_id").value;
	//var supplier = document.getElementById("suppliers").value;
	
	var status = true;
	
	if(name == ""){
		inlineMsg('name','<strong>Error</strong><br />Please enter the Name!',2);
		status = false;
	} else if(product == "-"){
		inlineMsg('products','<strong>Error</strong><br />Please select the product!',2);
    	status = false;
	} else if(short_desc == ""){
		inlineMsg('short_desc','<strong>Error</strong><br />Please enter the Short Desc!',2);
		status = false;
	} else if(description == ""){
		inlineMsg('specification_label','<strong>Error</strong><br />Please enter the Specification!',2);
		status = false;
	} else if(price == ""){
		inlineMsg('price','<strong>Error</strong><br />Please enter the Price!',2);
		status = false;
	} else if(stock == ""){
		inlineMsg('stock','<strong>Error</strong><br />Please enter the Stock!',2);
		status = false;
	} else if(ref_id == ""){
		inlineMsg('ref_id','<strong>Error</strong><br />Please enter the Reference ID!',2);
		status = false;
	} 
	  
	if(status){
		save();
	}	
}
	
function save(){
	document.getElementById("save_result").innerHTML = "<img src='images/loading.gif'>";
	var name = document.getElementById("name").value;
    var product = document.getElementById("products").value;
	var short_desc = document.getElementById("short_desc").value;
	var description = CKEDITOR.instances.description.getData();
	var price = document.getElementById("price").value;
	var stock = document.getElementById("stock").value;
	var ref_id = document.getElementById("ref_id").value;
	var keywords = document.getElementById("keywords").value;
	var rating = document.getElementById("rating_select").value;
    var badge = document.getElementById("badge_select").value;
    var status = document.getElementById("status_select").value;

	var urlString = "item.logic.php";
	var parameters = "chksql=saveItem&name="+escape(name)+"&prod_id="+product+"&short_desc="+escape(short_desc)+
  "&desc="+escape(description)+"&price="+price+"&stock="+stock+"&ref_id="+ref_id+"&keywords="+keywords+"&rating="+rating+"&badge="+badge+"&status="+status;	

    //alert(parameters);	
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = http.responseText;
				document.getElementById("save_result").innerHTML = "";
				if(result.indexOf("SUCCESS") > -1){
					document.getElementById("save_result").style.color = "blue";
					document.getElementById("save_result").innerHTML = "Item Created Successfully!";		
					init();					
				}else{
					document.getElementById("save_result").style.color = "red";
					document.getElementById("save_result").innerHTML = "Error Occured! Please try Again.";
				}
			}else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(parameters); 
}

function editProduct(){
	var product = document.getElementById("products").value;
	if(product == "-"){
		inlineMsg('products','<strong>Error</strong><br />Please select the Product you want to Edit!',2);
	}else{
		window.location = "edit_product.php?id="+product;		
	}
}

function deleteProduct(){
	var product = document.getElementById("products").value;
	if(product == "-"){	
		inlineMsg('products','<strong>Error</strong><br />Please select the Product you want to Delete!',2);
	}else{
		var result = confirm("Are You Sure! You want to delete this Product?");
		if(result){
			document.getElementById("delete_result").innerHTML = "<img src='images/loading.gif'>";
			var urlString = "item.logic.php";
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
							init();					
						}else{
							document.getElementById("delete_result").style.color = "red";
							document.getElementById("delete_result").innerHTML = "Error Occured! Please try Again.";
						}
						//var t=setTimeout("resetPage()",3000);
					}else{
						//alert("Error Occured : " + http.statusText);
						}
				}
			}
			http.send(parameters); 	
		}
	}
}

function resetPage(){
	document.location.reload();
}	

function startUpload(){
	var ref_id =  document.getElementById("ref_id").value;	
	var valid = true;
	
	if(ref_id == ""){
		inlineMsg('ref_id','<strong>Error</strong><br />Please enter the Reference ID!',2);
		valid = false;
	}
	
	if(valid) {		
		//alert('test');
		var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {			
			action: 'upload_item.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
					   // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				this.setData({'vid': ref_id});
				document.getElementById("loading_div").innerHTML = "Uploading...<img src='images/loading.gif'>";
			},
			onComplete: function(file, response){
				//On completion clear the status
				document.getElementById("loading_div").innerHTML = "";
				//Add uploaded file to list
				var folderName = '';
				folderName = document.getElementById("ref_id").value;
	
				var extension = '';
				extension = file.substring(file.indexOf("."),file.length);
				
				if(response.indexOf("success") > -1){
					document.getElementById("save_result").innerHTML = "";
					var imageID = '';
					imageID = response.substring(response.indexOf("#")+1,response.length);
	
					var url = '';
					url = '../item_images/'+folderName+'/th_'+folderName+'_'+imageID+extension;
	
					var m_files = '';
					m_files = "<li class='success'><img src='"+url+"?"+randomString()+"'><br/><img src='images/delete.gif'  style='Cursor: pointer' onClick=deleteImage('"+url+"');> Delete</li>";
					document.getElementById("files").innerHTML = document.getElementById("files").innerHTML + m_files;
					
				} else{
					alert(response);
				}
			}
		});	
	}
}

function deleteImage(url){
	var result = confirm("Are you sure! You want to Delete this image?");
	if(result){
		var ref_id = trim(document.getElementById("ref_id").value);
		var urlString = "item.logic.php";
    var parameters = "chksql=deleteProductImage&ref_id="+trim(ref_id)+"&url="+url;
		var http = getHTTPObject();
		http.open("POST", urlString , true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		http.onreadystatechange = function() {
			if (http.readyState == 4){
				if (http.status == 200) {
					var files = "";
					files = http.responseText;
					loadImages(files);
				} else{
					alert("Error Occured : " + http.statusText);
				}
			}
		}
		http.send(parameters); 		
	}
}

function loadImages(imagepaths){
	var m_files =  '';
	m_files = trim(imagepaths).split('@');	
	document.getElementById("files").innerHTML = "";
	var displayFiles = '';
	for(i = 0;i<= m_files.length-2; i++){		
		var url = '';
		url = trim(m_files[i]);//.replace("../","");
		displayFiles = displayFiles + "<li class='success'><img src='"+url+"?"+randomString()+"'><br/><img src='images/delete.gif'  style='Cursor: pointer' onClick=deleteImage('"+url+"')> Delete</li>";
	}	
	document.getElementById("files").innerHTML = displayFiles;
}

function randomString() {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var string_length = 8;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
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
                <td class="header_title" height="20">&nbsp;&nbsp;Backoffice Item Management</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="98%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
              </tr>
              
              <tr>
                <td>
                <fieldset class="fieldset">
                  <legend class="legend">Create New Item</legend>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                  <tr>
                    <td width="8%">&nbsp;</td>
                    <td width="18%">&nbsp;</td>
                    <td width="25%">&nbsp;</td>
                    <td width="41%">&nbsp;</td>
                    <td width="8%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Item Title</td>
                    <td colspan="2"><input name="name" type="text" class="body" id="name" size="40"></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Product</td>
                    <td><div id="products_div"></div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>                 
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Description</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="3"><textarea cols="80" id="short_desc" name="short_desc" rows="5"></textarea></td>
                    <td>&nbsp;</td>
                  </tr>                  
                  <tr>
                    <td>&nbsp;</td>
                    <td id="specification_label" name="specification_label">Specification</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="3"><textarea class="ckeditor" cols="50" id="description" name="description" rows="15"></textarea></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Price</td>
                    <td><input type="text" name="price" id="price" class="body"></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Stock</td>
                    <td><input type="text" name="stock" id="stock" class="body"></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Reference ID (SKU)</td>
                    <td><input type="text" name="ref_id" id="ref_id" class="body"></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Keywords</td>
                    <td><input type="text" name="keywords" id="keywords" class="body"></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Images</td>
                    <td><div id="upload" onClick="startUpload();">Upload Images</div></td>
                    <td><div id="loading_div"></div></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="3"><ul id="files" ></ul></td>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Product Rating</td>
                    <td><div id="rating_select_div"></div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Display Badge</td>
                    <td><div id="badge_select_div"></div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>                  

                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Status</td>
                    <td><div id="status_select_div"></div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>                  
                  
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input type="button" name="submit" id="submit" value="Create Item" class="body" onClick="validateEntry();">
                      <input type="button" name="button2" id="button2" value="Reset" class="body" onClick="resetPage();"></td>
                    <td><div id="save_result"></div></td>
                    <td>&nbsp;</td>
                  </tr>                  
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="center">&nbsp;</td>
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


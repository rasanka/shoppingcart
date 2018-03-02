<?php
	ob_start();
	include_once ("config/config.php");
	require_once ("product.class.php");
	
	if($_SESSION["ses_user_name"] == null || $_SESSION["ses_user_name"] == "" || !isset($_SESSION["ses_user_name"])){
		session_destroy();
		header("Location:index.php");
		die();
	}
	
	if($_SESSION["ses_user_level"] == "ADMIN"){ 	
		$id = $_GET['id'];
	}
	if($id == ""){
		header("Location:product.php");
		die();
	}
		
	$obj   = new Product();
		
	$details = array();
	$details = $obj -> getProductDetailsById($id);

  $imageNames = array();
  $imageNames = $obj -> getProductImages($id);

  $imagePaths = "";
  $i = 0;
	while ($i < count($imageNames)) {
    // $directory = "../product_images/".$ref_id."/";	
		$imagePaths = $imagePaths."../product_images/".$id."/".$imageNames[$i][0].'@';			
		$i +=1;
	} 

  // $short_desc = addslashes($details['short_desc']);
  // $product_desc = addslashes($details['desc']);

  // echo $details['rating'].'-'.$details['badge'];
		
	if(count($details) == 0){
		header("Location:product.php");
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

function loadDashBoard(){
	loadCategoryList();
  	loadBrandList();
  	loadStatusList();  
  	loadImages("<?php echo $imagePaths; ?>");
}

function loadCategoryList(){
	var urlString = "category.logic.php?chksql=loadCategoryList";
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				document.getElementById("categories_div").innerHTML = http.responseText;
				document.getElementById("categories").value = "<?php echo $details['cat_id']; ?>";
			}else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(null); 		
}

function loadBrandList(){
	var urlString = "brand.logic.php?chksql=loadBrandList";
	var http = getHTTPObject();
	http.open("GET", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				document.getElementById("brands_div").innerHTML = http.responseText;
        document.getElementById("brands").value = "<?php echo $details['brand_id']; ?>";
			}else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(null); 		
}

function loadStatusList(){
	document.getElementById("status_select_div").innerHTML = "<img src='images/loading.gif'>";
	var urlString = "product.logic.php";
  var parameters = "chksql=loadStatusList";
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				document.getElementById("status_select_div").innerHTML = "";
				document.getElementById("status_select_div").innerHTML = http.responseText;
        document.getElementById("status_select").value = "<?php echo $details['status']; ?>";
			} else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(parameters); 	
}

function validateEntry(){
	var name = document.getElementById("name").value;
	var category = document.getElementById("categories").value;
	var brand = document.getElementById("brands").value;
  	var ref_id = document.getElementById("ref_id").value;  
	
	var status = true;
	
	if(name == ""){
		inlineMsg('name','<strong>Error</strong><br />Please enter the Name!',2);
		status = false;
	} else if(category == "-"){
		inlineMsg('categories','<strong>Error</strong><br />Please select the Category!',2);
    	status = false;
	} else if(brand == "-"){
		inlineMsg('brands','<strong>Error</strong><br />Please select the Brand!',2);
    	status = false;
	} else if(ref_id == ""){
		inlineMsg('ref_id','<strong>Error</strong><br />Please enter the Reference ID!',2);
		status = false;
	} 
	  
	if(status){
		update();
	}	
}
	
function update(){
	var id = "<?php echo $id; ?>";
	var name = document.getElementById("name").value;
	var category = document.getElementById("categories").value;
	var brand = document.getElementById("brands").value;
  	var ref_id = document.getElementById("ref_id").value;
	var status = document.getElementById("status_select").value;
	
	var urlString = "product.logic.php";
	var parameters = "chksql=updateProduct&id="+id+"&name="+escape(name)+"&cat_id="+category+"&brand_id="+brand+"&ref_id="+ref_id+"&status="+status; 

  //alert(parameters);
	var http = getHTTPObject();
	http.open("POST", urlString , true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = http.responseText;
				//alert(result);
				if(result.indexOf("SUCCESS") > -1){
					document.getElementById("save_result").style.color = "blue";
					document.getElementById("save_result").innerHTML = "Product Updated Successfully!";							
				}else{
					document.getElementById("save_result").style.color = "red";
					document.getElementById("save_result").innerHTML = "Error Occured! Please try Again.";
				}
				//var t=setTimeout("resetPage()",3000);
			}else{
				//alert("Error Occured : " + http.statusText);
				}
		}
	}
	http.send(parameters); 
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
			action: 'upload.php',
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
				folderName = '<?php echo $id; ?>';
	
				var extension = '';
				extension = file.substring(file.indexOf("."),file.length);
				
				if(response.indexOf("success") > -1){
					document.getElementById("save_result").innerHTML = "";
					var imageID = '';
					imageID = response.substring(response.indexOf("#")+1,response.length);
	
					var url = '';
					url = '../product_images/'+folderName+'/th_'+folderName+'_'+imageID+extension;
	
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
		var ref_id = '<?php echo $id; ?>';
		var urlString = "product.logic.php";
    var parameters = "chksql=deleteProductImage&ref_id="+trim(ref_id)+"&url="+url;
		var http = getHTTPObject();
		http.open("POST", urlString , true);

		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//http.setRequestHeader("Content-length", parameters.length);
		//http.setRequestHeader("Connection", "close");

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
				
<body onLoad="loadNewMenu(); loadDashBoard();">	
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
                <td class="header_title" height="20">&nbsp;&nbsp;&nbsp;Backoffice Product Management - Edit Product ID - <?php echo $id; ?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="98%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
              </tr>
              
              <tr>
                <td>
                <fieldset class="fieldset">
                <legend class="legend">Create New Product</legend>
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
                    <td>Product Title</td>
                    <td colspan="2"><input name="name" type="text" class="body" id="name" size="40" value="<?php echo $details['name']; ?>"></td>
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
                    <td>Category</td>
                    <td><div id="categories_div"></div></td>
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
                    <td>Brand</td>
                    <td><div id="brands_div"></div></td>
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
                    <td><input type="text" name="ref_id" id="ref_id" class="body"  value="<?php echo $details['ref_id']; ?>" disabled></td>
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
                    <td><input type="button" name="submit" id="submit" value="Update Product" class="body" onClick="validateEntry();">
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


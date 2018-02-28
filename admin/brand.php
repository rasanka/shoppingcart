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

<script src="javascript/XMLHTTP.js" type="text/javascript" charset="utf-8"></script>	
<script src="javascript/common.js" type="text/javascript" charset="utf-8"></script>
<script src="javascript/cssverticalmenu.js" type="text/javascript" charset="utf-8"></script>	
<script src="javascript/jquery.js" type="text/javascript" charset="utf-8"></script>	
<script src="javascript/messages.js" type="text/javascript" charset="utf-8"></script>

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
		loadCategoryList();
    loadBrandList();
	}
}

function loadCategoryList(){
	var urlString = "category.logic.php?chksql=loadCategoryList";
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				document.getElementById("categories_div").innerHTML = http.responseText;
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
	http.open("POST", urlString , true);
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
	
function validateEntry(){
	var name = document.getElementById("name").value;
  var category = document.getElementById("categories").value;
	
	var status = true;
	
	if(name == ""){
		inlineMsg('name','<strong>Error</strong><br />Please enter the Name!',2);
		status = false;
	} else if(category == "-"){
		inlineMsg('categories','<strong>Error</strong><br />Please select the Category!',2);
    status = false;
	}
	  
	if(status){
		save();
	}	
}
	
function save(){
	document.getElementById("save_result").innerHTML = "<img src='images/loading.gif'>";
	var name = document.getElementById("name").value;
  var category = document.getElementById("categories").value;

	var urlString = "brand.logic.php?chksql=saveBrand&name="+name+"&cat_id="+category;
	//alert(urlString);			
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = http.responseText;
				document.getElementById("save_result").innerHTML = "";
				if(result.indexOf("SUCCESS") > -1){
					document.getElementById("save_result").style.color = "blue";
					document.getElementById("save_result").innerHTML = "Brand Created Successfully!";		
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
	http.send(null); 
}

function editBrand(){
	var brand = document.getElementById("brands").value;
	if(brand == "-"){
		inlineMsg('brands','<strong>Error</strong><br />Please select the Brand you want to Edit!',2);
	}else{
		window.location = "edit_brand.php?id="+brand;		
	}
}

function deleteBrand(){
	var brand = document.getElementById("brands").value;
	if(brand == "-"){	
		inlineMsg('brands','<strong>Error</strong><br />Please select the Brnad you want to Delete!',2);
	}else{
		var result = confirm("Are You Sure! You want to delete this Brand?");
		if(result){
			document.getElementById("delete_result").innerHTML = "<img src='images/loading.gif'>";
			var urlString = "brand.logic.php?chksql=deleteBrand&id="+brand;
			//alert(urlString);			
			var http = getHTTPObject();
			http.open("POST", urlString , true);
			http.onreadystatechange = function() {
				if (http.readyState == 4){
					if (http.status == 200) {
						var result = http.responseText;
						document.getElementById("delete_result").innerHTML = "";
						if(result.indexOf("SUCCESS") > -1){
							document.getElementById("delete_result").style.color = "blue";
							document.getElementById("delete_result").innerHTML = "Brand Deleted Successfully!";		
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
			http.send(null); 	
		}
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
                <td class="header_title" height="20">&nbsp;&nbsp;&nbsp;Backoffice Product Brand Management</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="98%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
              </tr>
              
              <tr>
                <td>
                <fieldset class="fieldset">
                <legend class="legend">Create New Brand</legend>
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
                    <td>Brand Name</td>
                    <td><input type="text" name="name" id="name" class="body"></td>
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
                    <td>&nbsp;</td>
                    <td><input type="button" name="submit" id="submit" value="Create Brand" class="body" onClick="validateEntry();">
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
                </fieldset>                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><fieldset class="fieldset">
                <legend class="legend">Edit Brand</legend>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                  <tr>
                    <td width="8%">&nbsp;</td>
                    <td width="18%">&nbsp;</td>
                    <td width="25%" colspan="2"><div id="delete_result"></div></td>
                    <td width="8%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Select Brand to Edit</td>
                    <td width="25%"><div id="brands_div"></div></td>
                    <td width="41%"><input type="button" name="submit2" id="submit2" value="Edit Brand" class="body" onClick="editBrand();">
                      <input type="button" name="submit3" id="submit3" value="Delete Brand" class="body" onClick="deleteBrand();"></td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
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


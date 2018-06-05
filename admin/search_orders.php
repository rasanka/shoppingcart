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
<link rel="stylesheet" href="css/ui.datepicker.css" type="text/css" media="screen" title="core css file" charset="utf-8" />

<script src="javascript/XMLHTTP.js" type="text/javascript" charset="utf-8"></script>	
<script src="javascript/common.js" type="text/javascript" charset="utf-8"></script>
<script src="javascript/cssverticalmenu.js" type="text/javascript" charset="utf-8"></script>
<script src="javascript/messages.js" type="text/javascript" charset="utf-8"></script>
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/jquery-1.3.2.js" ></script>
<script src="javascript/ui.datepicker.js" type="text/javascript" charset="utf-8"></script>

<script language="JavaScript" type="text/javascript">  
jQuery(function($){
  $("#from_date").datepicker();
  $("#to_date").datepicker();
});

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function init(){
	var level = "<?php echo $_SESSION["ses_user_level"]; ?>";
	if(level == "ADMIN"){
     setDefaultDate();
	}
}

function setDefaultDate(){
	var currentDate = new Date();
	var month = currentDate.getMonth()+1;
	var day = currentDate.getDate();
	var year = currentDate.getFullYear();	
	//alert(String(month).length);
	if(String(month).length == 1){
		month = "0"+month;
	}if(String(day).length == 1){
		day = "0"+day;
	}		
	//alert("DATE CALL");
	document.getElementById("from_date").value = month+"/"+day+"/"+year;
	document.getElementById("to_date").value = month+"/"+day+"/"+year;
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

function deleteItem(pid){
  alert(pid);
	var product = pid;
	var result = confirm("Are You Sure! You want to delete this Product?");
	if(result){
		document.getElementById("delete_result").innerHTML = "<img src='images/loading.gif'>";
		var urlString = "item.logic.php";
		var parameters = "chksql=deleteItem&id="+product;
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
          searchItems();
				}
			}
		}
		http.send(parameters); 	
	}
}

function searchItems(){
	var name = document.getElementById("name").value;
  var product = document.getElementById("products").value;
	//var brand = document.getElementById("brands").value;
  var ref_id = document.getElementById("ref_id").value;
	
	if(product == "-"){
		inlineMsg('products','<strong>Error</strong><br />Please select the Product!',2);
    	status = false;
	} else {		
		document.getElementById("product_list_div").innerHTML = "<img src='images/loading.gif'>";
		var urlString = "item.logic.php";
    var parameters = "chksql=searchItems&name="+name+"&prod_id="+product+"&ref_id="+ref_id;
		//alert(parameters);
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
                <legend class="legend">Search Orders</legend>
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
                    <td>Order Id</td>
                    <td><input name="order_id" type="text" class="body" id="order_id" size="20"></td>
                    <td>&nbsp;</td>
                    <td>Order State</td>
                    <td>
                        <select name='order_state' id='order_state' class='body' onChange=''>
                            <option value='-'> -- Please Select --</option>
                            <option value='PENDING_PAYMENT'>Pending Payment</option>
                            <option value='PENDING_APPROVAL'>Pending Approval</option>
                            <option value='PAYMENT_APPROVED'>Approved Orders</option>
                            <option value='SHIPPED'>Shipped Orders</option>
                    </td>
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
                    <td>From Date</td>
                    <td><input name="from_date" type="text" class="body" id="from_date"></td>
                    <td>&nbsp;</td>
                    <td>To Date</td>
                    <td><input name="to_date" type="text" class="body" id="to_date"></td>
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
                    <td><input type="button" name="submit2" id="submit2" value="Search Orders" class="body" onClick="searchOrders();"></td>
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


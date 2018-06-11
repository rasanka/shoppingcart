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

function searchOrders(){
	var orderId = document.getElementById("order_id").value;
  var orderState = document.getElementById("order_state").value;
  var fromDate = document.getElementById("from_date").value;
  var toDate = document.getElementById("to_date").value;
		
	document.getElementById("order_list_div").innerHTML = "<img src='images/loading.gif'>";
	var urlString = "order.logic.php";
  var parameters = "chksql=searchOrders&id="+orderId+"&state="+orderState+"&fromDate="+fromDate+"&toDate="+toDate;
  //alert(parameters);
	var http = getHTTPObject();
	http.open("POST", urlString , true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = http.responseText;
        //alert(result);
				document.getElementById("search_result_div").style.display="inline";
				document.getElementById("order_list_div").innerHTML = "";
				document.getElementById("order_list_div").innerHTML = result;						
			} 
			else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(parameters);				
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
                    <td colspan="5"><hr/></td>
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
                    <td><input type="button" name="searchButton" id="searchButton" value="Search Orders" class="body" onClick="searchOrders();"></td>
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
                    <td><div id="order_list_div"></div></td>
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


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
<link rel="stylesheet" href="css/thumbnail.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
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

// var int=self.setInterval(function(){init()},10000);

function init(){
	//loadDashbordSummary();
}

function setCursor(){
	init();
	loadOrdersToBeShipped();
}

function loadOrdersToBeShipped(){
	document.getElementById("item_list_div").innerHTML = "<img src='images/loading.gif'>";
	var urlString = "order.logic.php?chksql=loadOrdersToBeShipped";
	var http = getHTTPObject();
	http.open("GET", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = http.responseText;
				document.getElementById("item_list_div").innerHTML = "";
				document.getElementById("item_list_div").innerHTML = result;						
			}
		}
	}
	http.send(null);		
}


function approve(lno){
	var result = confirm("Are Your Sure! You want to Ship this Order?");
	if(result){
		var refId = document.getElementById("refId"+lno).value;    
		var urlString = "order.logic.php?chksql=shipOrder&id="+refId;
	    //alert(urlString);
  	    var http = getHTTPObject();
		http.open("GET", urlString , true);
		http.onreadystatechange = function() {
			if (http.readyState == 4){
				if (http.status == 200) {
					var result = http.responseText;
					if(result.indexOf("SUCCESS") > -1){
						sendApproveMail(refId);
					}else{
						inlineMsg('app_check'+lno,'<strong>Error</strong><br />Please Try Again!',2);
					}
				} else{
					//alert("Error Occured 1: " + http.statusText);
				}
			}
		}
		http.send(null);		
	}
}

function sendApproveMail(refId){
	var urlString = "order.logic.php?chksql=generate_order_shipped_mail&id="+refId;
	//alert(urlString);
	var http = getHTTPObject();
	http.open("GET", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = trim(http.responseText);
				alert(result);
				loadOrdersToBeShipped();
			} else{
				//alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(null);		
}

function resetPage(){
	document.location.reload();
}	
				
</script>
</head>				
				
<body onLoad="loadNewMenu(); setCursor();">	
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
                <td class="header_title" height="20">&nbsp;&nbsp;&nbsp;Order's to be Shipped</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="98%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
              </tr>
              
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>
                <fieldset class="fieldset">
                <legend class="legend">Paid Orders</legend>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="98%">&nbsp;</td>
                    <td width="1%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><div id="item_list_div"></div></td>
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


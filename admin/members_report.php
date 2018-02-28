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
<link rel="stylesheet" type="text/css" href="css/notifications.css">
<link rel="stylesheet" type="text/css" href="css/paging.css">

<script src="javascript/XMLHTTP.js" type="text/javascript" charset="utf-8"></script>	
<script src="javascript/common.js" type="text/javascript" charset="utf-8"></script>
<script src="javascript/cssverticalmenu.js" type="text/javascript" charset="utf-8"></script>	

<script language="JavaScript" type="text/javascript">  

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
var int=self.setInterval(function(){loadDashBoard()},10000);

function loadDashBoard(){
	//loadDashbordSummary();
}

function init(){
	//loadDashBoard();
	loadReport(0);
}

function loadReport(limit){
	// document.getElementById("report_div").innerHTML = "<img src='images/loading.gif'>";
	// var urlString = "admin_member.logic.php?chksql=loadMembersReport&limit="+limit;
	// //alert(urlString);
	// var http = getHTTPObject();
	// http.open("POST", urlString , true);
	// http.onreadystatechange = function() {
	// 	if (http.readyState == 4){
	// 		if (http.status == 200) {
	// 			var result = http.responseText;
	// 			document.getElementById("serach_result_div").style.display="inline";
	// 			document.getElementById("legend_div").innerHTML = "All Registered Members";
	// 			//Registered Members Summary
	// 			document.getElementById("report_div").innerHTML = "";
	// 			document.getElementById("report_div").innerHTML = result;						
	// 		} 
	// 	}
	// }
	// http.send(null);		
}	

function searchEntry(){
	var pay_status = document.getElementById("pay_status").value;
			
	document.getElementById("report_div").innerHTML = "<img src='images/loading.gif'>";
	var urlString = "admin_member.logic.php?chksql=searchMembers&status="+pay_status;
	//alert(urlString);
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = http.responseText;
				document.getElementById("serach_result_div").style.display="inline";
				document.getElementById("legend_div").innerHTML = "Search Result";
				document.getElementById("report_div").innerHTML = "";
				document.getElementById("report_div").innerHTML = result;						
			} 
			else{
				alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(null);				
}		

function showItems(lno){
	var id = document.getElementById("hid_id"+lno).value;
	var already_expired = document.getElementById("hid_already_expired"+lno).value;
	var tobe_expired = document.getElementById("hid_tobe_expired"+lno).value;

	var urlString = "admin_member.logic.php?chksql=loadMemberDetails&id="+id+"&lno="+lno+"&already_ex="+already_expired+"&tobe_ex="+tobe_expired;
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				document.getElementById("item_div"+lno).innerHTML = http.responseText;
				document.getElementById("show_div"+lno).innerHTML = "<img src='images/minus.gif' alt='Hide Items' style='cursor:hand' onClick='hideItems("+lno+");'>";
			} 
		}
	}
	http.send(null);	
}

function generatePaymentEmail(id){
	var urlString = "<?php echo $SERVER_URL;?>send_mail.logic.php?chksql=generate_payment&id="+id;
	//alert(urlString);
	var http = getHTTPObject();
	http.open("GET", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = trim(http.responseText);
				alert(result);
			} else{
				//alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(null);		
	
}

function updateExpDate(id){
	var urlString = "<?php echo $SERVER_URL;?>send_mail.logic.php?chksql=update_exp_date&id="+id;
	//alert(urlString);
	var http = getHTTPObject();
	http.open("GET", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = trim(http.responseText);
				alert(result);
			} 
		}
	}
	http.send(null);		
	
}

function notifyExpDate(id){
	var urlString = "<?php echo $SERVER_URL;?>send_mail.logic.php?chksql=notify_exp_date&id="+id;
	//alert(urlString);
	var http = getHTTPObject();
	http.open("GET", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = trim(http.responseText);
				alert(result);
			} 
		}
	}
	http.send(null);		
	
}

function completePayment(id,lno){
	var type = document.getElementById("paymtdsel"+lno).value;
	var urlString = "admin_member.logic.php?chksql=updatePaymentManually&id="+id+"&type="+type;
	var http = getHTTPObject();
	http.open("GET", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = http.responseText;
				if(result.indexOf("SUCCESS") > -1){
					alert("Updated Successfully!");
					init();
				}else{
					alert("Error Occured!");
				}
			} 
		}
	}
	http.send(null);	
}

function hideItems(lno){
	document.getElementById("item_div"+lno).innerHTML = "";
	document.getElementById("show_div"+lno).innerHTML = "<img src='images/plus.gif' alt='Show Items' style='cursor:hand' onClick='showItems("+lno+");'>";
	
}

function resetPage(){
	document.location.reload();
}
</script>

</head>				
				
<body onLoad="loadNewMenu(); init();">	
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
                <td class="header_title" height="20">&nbsp;&nbsp;&nbsp;Registered Members Summary</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="98%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
              </tr>    

              <tr>
                <td>
                <fieldset class="fieldset">
                <legend class="legend">Filter Registered Members </legend>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                  <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="15%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="15%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><strong>Search By</strong></td>
                    <td>&nbsp;</td>
                    <td colspan="2" valign="middle">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                                   
                                    
                  <tr>
                    <td>&nbsp;</td>
                    <td>Payment Status</td>
                    <td><select name="pay_status" id="pay_status" class="body">
                      <option value="SUCCESS">Payment Success</option>
                    </select></td>
                    <td colspan="2" valign="middle">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2" valign="middle">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input type="button" name="find_but" id="find_but" value=" Find " class="body" onClick="searchEntry();">
                      <input type="button" name="reset_but1" id="reset_but1" value="Reset" class="body" onClick="resetPage();"></td>
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
                <td>
                <div id="serach_result_div" style="display:none">
                <fieldset class="fieldset">
                <legend class="legend"><div id="legend_div"></div></legend>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="98%">&nbsp;</td>
                    <td width="1%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><div id="report_div"></div></td>
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


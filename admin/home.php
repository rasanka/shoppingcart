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

<script src="javascript/messages.js" type="text/javascript" charset="utf-8"></script>	
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

var int=self.setInterval(function(){init()},10000);

function init(){
	// loadRequestsSummary();
	// loadLoggedInUsers();
	// loadMembersSummary();
	// loadActiveDoctor();
	// loadDashbordSummary();
}

function loadRequestsSummary(){
	var urlString = "admin_member.logic.php?chksql=getDashbordStats";
	//alert(urlString);
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = http.responseText;
				var data = result.split("#");
				document.getElementById("noOfNewMemReq_div").innerHTML = data[0];
				document.getElementById("noOfNewVisReq_div").innerHTML = data[1];
				document.getElementById("noOfNewMemRep_div").innerHTML = data[2];
				document.getElementById("noOfNewVisRep_div").innerHTML = data[3];
				document.getElementById("paymentsApp_div").innerHTML = data[4];
				document.getElementById("membersExp_div").innerHTML = data[5];
			} else{
				//alert("Error Occured 1: " + http.statusText);
			}
		}
	}
	http.send(null);
}

function loadLoggedInUsers(){
	var urlString = "admin_member.logic.php?chksql=getLoggedInUsers";
	//alert(urlString);
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = http.responseText;
				document.getElementById("loggedInUsers_div").innerHTML = result;
			} else{
				//alert("Error Occured 1: " + http.statusText);
			}
		}
	}
	http.send(null);
}

function loadMembersSummary(){
	var urlString = "admin_member.logic.php?chksql=getMemberCounts";
	//alert(urlString);
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = http.responseText;
				var data = result.split("#");
				document.getElementById("regMembers_div").innerHTML = data[0];
				document.getElementById("onlineMembers_div").innerHTML = data[1];
				document.getElementById("regVisitors_div").innerHTML = data[2];
			} else{
				//alert("Error Occured 1: " + http.statusText);
			}
		}
	}
	http.send(null);
}

function loadActiveDoctor(){
	var urlString = "admin_member.logic.php?chksql=getActiveDoctor";
	//alert(urlString);
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.onreadystatechange = function() {
		if (http.readyState == 4){
			if (http.status == 200) {
				var result = http.responseText;
				//alert("<"+result+">");
				if(result.indexOf("EMPTY") > -1){
					document.getElementById("activeDoctor_div").innerHTML = "No Records Found!";
				}else{
					//alert(data);
					document.getElementById("activeDoctor_div").innerHTML = "Dr. "+result;
					//document.getElementById("activeTime_div").innerHTML = data[1];
				}
			} else{
				//alert("Error Occured 1: " + http.statusText);
			}
		}
	}
	http.send(null);
}
			
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {color: #0000CC}
.style3 {color: #009900}
-->
</style>
</head>				
				
<body onLoad="loadNewMenu();" >		
  <table width="1087" height="591" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
    <tr>
      <td height="19" align="right" class="body">&nbsp;&nbsp;&nbsp;Logged 
        In : <?php echo $_SESSION["ses_name"];?> [<?php echo $_SESSION["ses_user_level"];?>]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr> 
      <td width="1087" height="572" valign="top" class="body"> 
        <fieldset class="fieldset">
        <table width="100%" height="591" border="0" cellpadding="0" cellspacing="0" class="body">    
          <tr>
            <td width="20%" valign="top"><?php require_once("menu.php"); ?></td> 
            <td width="80%" height="450" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
              <tr height="20">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="header_title" height="20">&nbsp;&nbsp;&nbsp;Welcome to PhoneRepairParts.co.nz Backoffice</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="98%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
              </tr>
              <tr>
                <td>
                <fieldset class="fieldset">
                <legend class="legend">Dashboard </legend>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                  <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td width="2%">&nbsp;</td>
                    <td width="2%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td width="3%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="220">&nbsp;</td>
                    <td valign="top">
                    <!--
                    <fieldset class="fieldset"><legend class="legend">Request's Summary</legend>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                      <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="70%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="style1"><a href="member_requests.php" class="style1">New Member Request's</a></td>
                        <td class="table" align="center"><div id="noOfNewMemReq_div"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="style1"><a href="visitor_requests.php">New Visitor Request's</a></td>
                        <td class="table" align="center"><div id="noOfNewVisReq_div"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="style2"><a href="member_requests.php">Member Request's to be Respond</a></td>
                        <td class="table" align="center"><div id="noOfNewMemRep_div"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="style2"><a href="visitor_requests.php">Visitor Request's to be Respond</a></td>
                        <td class="table" align="center"><div id="noOfNewVisRep_div"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                    </fieldset>  
                    <br>  -->                
                    <fieldset class="fieldset">
                    <legend class="legend">Member's Summary</legend>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>                      
                      <tr>
                        <td>&nbsp;</td>
                        <td><a href="members_report.php">No. Of Registered Members</a></td>
                        <td class="table" align="center"><div id="regMembers_div"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><a href="visitors_report.php">No. Of Registered Visitors</a></td>
                        <td class="table" align="center"><div id="regVisitors_div"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="70%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>No. Of Online Members</td>
                        <td class="table" align="center"><div id="onlineMembers_div"></div></td>
                        <td>&nbsp;</td>
                      </tr>                      
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                    </fieldset>
                    <br>
					<fieldset class="fieldset">
                    <legend class="legend">Payments Summary</legend>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>                                            
                      <tr>
                        <td>&nbsp;</td>
                        <td><a href="approve_payment.php">Payment's to be Approved</a></td>
                        <td class="table" align="center"><div id="paymentsApp_div"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="70%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><a href="members_report.php">Memeber Account's to be Expired <br>
                        (30 days)</a></td>
                        <td class="table" align="center"><div id="membersExp_div"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                    </fieldset>                    
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td valign="top">
                    <fieldset class="fieldset">
                    <legend class="legend">Backoffice Logged In Users</legend>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><div id="loggedInUsers_div"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="3%">&nbsp;</td>
                        <td width="94%">&nbsp;</td>
                        <td width="3%">&nbsp;</td>
                      </tr>
                    </table>
                    </fieldset>                    
                    <br>
                    <!--
					<fieldset class="fieldset">
                    <legend class="legend">Active Doctor</legend>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr height="20">
                        <td>&nbsp;</td>
                        <td class="heading">Doctor </td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><div id="activeDoctor_div"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="3%">&nbsp;</td>
                        <td width="94%">&nbsp;</td>
                        <td width="3%">&nbsp;</td>
                      </tr>
                    </table>
                    </fieldset>      
                    -->                                  
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


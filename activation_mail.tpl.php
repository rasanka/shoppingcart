<?php 

  // <img src='/images/logo_new.jpg' width='242' height='97' />
	$activation_mail =  "<html>
						<head>
						<title>Activate Your account at PhoneRepairParts.co.nz</title>
						<style>
						.body {font-family: Verdana; font-size: 11px; color: #000000; }
						</style> 
						</head>
                        <body>
                        <table width='60%' border='0' class='body'>
                          <tr>
                            <td width='100%' colspan='2'></td>
                          </tr>
                          <tr>
                            <td colspan='2'>&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan='2'><p>Dear ".strtoupper($f_name).",<br><br>
                                Thank you for registering with PhoneRepairParts.co.nz. Before we can activate your account one last step must be taken to complete your registration.</p>
                              <p>Please note - you must complete this last step to become a fully registered user. You will only need to visit this URL once to activate your account.</p>
                              <p><a href='".$SERVER_URL."index.php?page=activate&id=".base64_encode($userId)."'>Click here</a> to activate your account.</p>
                              </td>
                          </tr>
                          
                          <tr>
                            <td colspan='2'><p><br>
                                  Thank You,<br>
                                  PhoneRepairParts.co.nz Team<br>
                                  <a href='http://www.phonerepairparts.co.nz'>www.phonerepairparts.co.nz</a><br><br>
                              </p>
						              	</td>
                          </tr>
                        </table>
                        </body>
						</html> ";
?>
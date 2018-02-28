<?php 

	// <img src='/images/logo_new.jpg' width='242' height='97' />
	$forgot_pwd_mail =  "<html>
						<head>
						<title>Forgot password for PhoneRepairParts.co.nz</title>
						<style>
						.body {font-family: Verdana; font-size: 11px; color: #000000; }
						</style> 
						</head>
						<body>
						<table width='60%' border='0' class='body'>
						  <tr>
							<td colspan='2'></td>
						  </tr>
						  <tr>
							<td colspan='2'>&nbsp;</td>
						  </tr>
						  <tr>
							<td colspan='2'><p>Dear ".strtoupper($details['fname']).",<br><br>
								Your password is as follows.<br><br>
							</p></td>
						  </tr>
						  <tr>
							<td width='12%'>Password</td>
							<td width='88%'>: ".$details['password']."</td>
						  </tr>
						  <tr>
							<td colspan='2'>&nbsp;</td>
						  </tr>
						  <tr>
								<td colspan='2'>
									<p>Click <a href='http://www.shoppnigit.com.au/index.php?page=account'>here</a> to login to the PhoneRepairParts.co.nz<br><br>
									Thank You,<br>
									PhoneRepairParts.co.nz Team<br>
									<a href='http://www.shoppnigit.com.au'>www.shoppnigit.com.au</a>
									<br><br>
								</p>
								</td>
						  </tr>
						</table>
						</body>
						</html> ";
?>
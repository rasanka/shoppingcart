<?php 

  require_once("config/config.php");
  // <img src='/images/logo_new.jpg' width='242' height='97' />
	$bank_payment_mail = "<html>
						<head>
						<title>PhoneRepairParts.co.nz</title>
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
                            <td colspan='2'><p>Dear ".strtoupper($bill_fname).",<br><br>
                                  Thank you for using PhoneRepairParts.co.nz. Please use the following bank account details to deposit the invoice amount.</p>
                              </td>
                          </tr>
                                                  
                          <tr>
                            <td colspan='2'>&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan='2'><table width='100%' border='0' cellspacing='0' cellpadding='0' class='body'>
                              <tr>
                                <td width='7%'>&nbsp;</td>
                                <td width='21%'>Reference No </td>
                                <td width='72%'>: ".$order_id."</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>Account No </td>
                                <td>: ".$ACCOUNT_NO."</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>Account Name </td>
                                <td>: ".$ACCOUNT_NAME."</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>Bank </td>
                                <td>: ".$BANK_NAME."</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>Branch </td>
                                <td>: ".$BRANCH_NAME."</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>Amount </td>
                                <td>: $ ".$cart_total."</td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td colspan='2'>&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan='2'>Make sure you put the above reference number in the deposit slip and keep it for further reference untill PhoneRepairParts.co.nz approves your transaction.
                            <p>&nbsp;</p>
                            </td>
                          </tr>
                          <tr>
                            <td colspan='2'><p>After depositing money login to your PhoneRepairParts.co.nz account and go to My orders and upload the bank receipt to your order.
                            <br/>
                            Once the PhoneRepairParts.co.nz approved the payment you will receive the order confirmation email to your registered email address.
                            </p>
                            <p>&nbsp;</p></td>
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
						</html>";
						
?>						
<?php 

  //<img src='/images/logo_new.jpg' width='242' height='97' />
	$approve_payment_mail = "<html>
                        <head>
                        <title>PhoneRepairParts.co.nz</title>
                        <style>
                        .body {font-family: Verdana; font-size: 11px; color: #000000; }
                        </style> 
                        </head>
                        <body>
                        <table width='100%' border='0' class='body'>
                          <tr>
                            <td width='100%' colspan='2'></td>
                          </tr>
                          <tr>
                            <td colspan='2'>&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan='2'>
                              <p>Dear ".strtoupper($details['billing_name']).",
                              <br><br>
                              Thank you for using PhoneRepairParts.co.nz. Your Payment is successfull.
                              <br><br>
                              Your order details successfully processed and scheduled for delivery.
                              <br><br>
                              You can track the order status by loggin in to your account and accessing the My Order section. 
                              Thank you once again for choosing PhoneRepairParts.co.nz.
                              </p>
                            </td>
                          </tr>
                                                                          
                          <tr>
                            <td colspan='2'>&nbsp;</td>
                          </tr>

                          <tr>
                            <td colspan='2'>".$order_summary_html."</td>
                          </tr>    

                          <tr>
                            <td colspan='2'>&nbsp;</td>
                          </tr>
                          <tr>
                            <th align='left' colspan='2'>Billing Address</td>
                          </tr>                                                                          
                          <tr>
                            <td colspan='2'>".$details['billing_address']."</td>
                          </tr>                                                                           
                          <tr>
                            <th width='10%' align='left'>Name</th>
                            <td>".$details['billing_name']."</td>
                          </tr>                                                                        
                          <tr>
                            <th align='left'>Company</th>
                            <td>".$details['billing_company']."</td>
                          </tr>                                                                        
                          <tr>
                            <th align='left'>Email</th>
                            <td>".$details['billing_email']."</td>
                          </tr>                                                                        
                          <tr>
                            <th align='left'>Contact</th>
                            <td>".$details['billing_contact']."</td>
                          </tr>                                                                        


                          <tr>
                            <td colspan='2'>&nbsp;</td>
                          </tr>
                          <tr>
                            <th align='left' colspan='2'>Delivery Address</td>
                          </tr>                                                                          
                          <tr>
                            <td colspan='2'>".$details['delivery_address']."</td>
                          </tr>   
                          <tr>
                            <th width='10%' align='left'>Name</th>
                            <td>".$details['delivery_name']."</td>
                          </tr>                                                                        
                          <tr>
                            <th align='left'>Company</th>
                            <td>".$details['delivery_company']."</td>
                          </tr>                                                                        
                          <tr>
                            <th align='left'>Email</th>
                            <td>".$details['delivery_email']."</td>
                          </tr>                                                                        
                          <tr>
                            <th align='left'>Contact</th>
                            <td>".$details['delivery_contact']."</td>
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
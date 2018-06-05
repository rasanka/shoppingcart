<?php
require_once ("config/config.php");
require_once ("order.class.php");
require_once ("cart.class.php");
require_once ("mail_logic.class.php");
require_once ("item.class.php");
	
$m_chksql = $_GET['chksql'];

$orderObj   = new Order();
$cartObj = new Cart();
$mailObj  = new MailLogic();
$productObj = new Item();

if($m_chksql == "loadBankPaymentsToBeApproved"){	

	$order_details = array();	
	$order_details = $orderObj -> getBankPaymentsToBeApproved();  
	
	if(count($order_details) > 1){
	
        // <th width='15%' align='left'>Transaction ID</td>
		$m_out = $m_out."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='body'>
						  <tr class='heading' height='20'>
							<th width='15%' align='left'>Order ID</td>							
							<th width='20%' align='left'>Deposit Slip</td>
							<th width='20%' align='left'>Order Total</td>
							<th width='20%' align='left'>Paid Date</td>
							<th width='10%'>Approve</td>
						  </tr> ";
		
		$num = 0;
		$color = "";
		$rowCount = 1;
		$i = 0;
		
		while($i < (count($order_details)/20)){
			
			$dir = "../bank_slips/".$order_details['order_id'.$rowCount]."/";
			$filecount = 0;
			if (glob($dir . "*.*") != false){
				$filecount = count(glob($dir . "*.*"));
			}else{
				$filecount = 0;
			}
			$files_str = "";
			if($filecount > 0){
				$files = glob($dir . "*.*");
				foreach($files as $file){
					$files_str = $file;
				}
			}	
					
            // <td>".$order_details['order_id'.$rowCount]."</td>         
			if($filecount == 0){
				$m_out = $m_out."<tr height='20' onMouseOver=this.className='highlight' onMouseOut=this.className='normal'>  
									<td>".$order_details['order_id'.$rowCount]."</td> 									
									<td>-</td> 
									<td>".number_format($order_details['order_total'.$rowCount],2)."</td> 
									<td>".$order_details['order_datetime'.$rowCount]."</td> 
									<td align='center'><input type='checkbox' name='app_check".$rowCount."' id='app_check".$rowCount."' onClick='approve(".$rowCount.");'></td>
									<input type='hidden' name='refId".$rowCount."' id='refId".$rowCount."' value='".$order_details['order_id'.$rowCount]."'>
								</tr> ";				
			
			}else{
				$m_out = $m_out."<tr height='20' onMouseOver=this.className='highlight' onMouseOut=this.className='normal'>  
									<td>".$order_details['order_id'.$rowCount]."</td> 
									<td onclick=openpopup('popup".$rowCount."');><img src='".$files_str."' width='20px' height='15px' border='0'/></td> 
									<td>".number_format($order_details['order_total'.$rowCount],2)."</td> 
									<td>".$order_details['order_datetime'.$rowCount]."</td> 
									<td align='center'><input type='checkbox' name='app_check".$rowCount."' id='app_check".$rowCount."' onClick='approve(".$rowCount.");'></td>
									<input type='hidden' name='refId".$rowCount."' id='refId".$rowCount."' value='".$order_details['order_id'.$rowCount]."'>
								</tr> 
								<div id='popup".$rowCount."' class='popup'><img src='".$files_str."' border='0' /></div> ";				
			}

				
			$rowCount += 1;		
			$i += 1;			
		}
		
		
				
		$m_out = $m_out."</table><div id='bg' class='popup_bg'></div> ";						
											
	} else {
		$m_out = $m_out."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='body'> ".
				 " <tr>  ".
				 "	<td>&nbsp;</td> ".
				 " </tr> ".		
				 " <tr height='20'>  ".
				 "	<td align='center'>No Records Found!</td> ".
				 " </tr> ".
				 " <tr>  ".
				 "	<td>&nbsp;</td> ".
				 " </tr> ".				 
				 "</table>";
	}
	echo $m_out;		
}

if($m_chksql == "approveBankPayment"){	

	$id= $_GET['id'];

	$msg = '';
	$msg = $orderObj -> approveBankPayment($id); 

	echo $msg;	

}

if($m_chksql == "shipOrder"){	

	$id= $_GET['id'];

	$msg = '';
	$msg = $orderObj -> shipOrder($id); 

	echo $msg;	

}

if($m_chksql == "generate_payment_success_mail"){

	$id = $_GET['id'];

	$details = array();	
    $details = $orderObj -> loadOrderDetailsById($id);

    $cart_id = $details['cart_id'];

    $cart_array = array();
    $cart_array = $cartObj -> loadCartById($cart_id);

    $cart_summary = "";
    $cart_items_html = "";
    $cart_item_count = 0;   

    $order_summary_html = "";
    $order_summary_tbl_start_html = "";
    $order_summary_tbl_end_html = "";
    $order_items_html = "";      
    
    if(count($cart_array) > 0){

        $order_summary_tbl_start_html = "
                    <table width='40%'  border='1' class='body'>
                      <thead>
                        <tr>
                          <th align='left' colspan='2'>Product</th>
                          <th align='left'>Qty</th>
                          <th align='left'>Unit Price</th>
                          <th align='left'>Total</th>
                        </tr>
                      </thead>
                      <tbody>        
        ";

        $item_array = array();
        $item_array = $cartObj -> loadCartItemsById($cart_id);                        

        $j = 0;
        $itemCount = 1;
        $cart_item_count = (count($item_array)/3);

        $order_items_html = "";
        
        while($j < $cart_item_count){

            $prod_id = $item_array['prod_id'.$itemCount];
            $prod_qty = $item_array['qty'.$itemCount];

            $prod_array = array();
            $prod_array = $productObj -> getItemDetailsById($prod_id); 

            if(count($prod_array) > 0){

                $item_total = ($prod_qty * $prod_array['price']);

                $order_items_html .= "
                    <tr>
                        <td colspan='2'>".$prod_array['name']."</td>
                        <td>".$prod_qty."</td>
                        <td>$".$prod_array['price']."</td>
                        <td>$".number_format((float)$item_total, 2, '.', '')."</td>
                    </tr>";
            }

            $itemCount += 1;
            $j +=1;
        }   

        $order_summary_tbl_end_html = "
                    </tbody>        
                      <tfoot>
					  	<tr> 
						  <th colspan='5'>&nbsp;</th>
						</tr>
                        <tr>                          
                          <th colspan='4'>Subtotal</th>
                          <td>$".$details['cart_total']."</td>
                        </tr>
                         <tr>
                          <th colspan='4'>Delivery</th>
                          <td>$".$details['delivery_amount']."</td>
                        </tr>
                         <tr>
                          <th colspan='4'>Total</th>
                          <td>$".$details['order_total']."</td>
                        </tr>
                      </tfoot>
                    </table>        
        ";

    }

    $order_summary_html = $order_summary_tbl_start_html.$order_items_html.$order_summary_tbl_end_html;

	$html = "";
	require_once("approve_payment_mail.tpl.php");
	$html = $approve_payment_mail;			
		
	$final_msg = $mailObj -> prepareHtmlMail($html);
	$subject = 'PhoneRepairParts.co.nz Payment Successfull.';
		
	if (mail($details['email'], $subject, $final_msg['multipart'], $final_msg['headers'])) {			
		echo "Email sent Successfully!";
	} else {
		echo "Message delivery failed!";
	}		
}

if($m_chksql == "loadOrdersToBeShipped"){	

	$order_details = array();	
	$order_details = $orderObj -> getOrdersToBeShipped();  
	
	if(count($order_details) > 1){
	
        // <th width='15%' align='left'>Transaction ID</td>
		$m_out = $m_out."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='body'>
						  <tr class='heading' height='20'>
							<th width='15%' align='left'>Order ID</td>							
							<th width='55%' align='left'>Address</td>
							<th width='20%' align='left'>Paid Date</td>
							<th width='10%'>Approve</td>
						  </tr> ";
		
		$num = 0;
		$color = "";
		$rowCount = 1;
		$i = 0;
		
		while($i < (count($order_details)/20)){

				$m_out = $m_out."<tr height='20' onMouseOver=this.className='highlight' onMouseOut=this.className='normal'>  
									<td>".$order_details['order_id'.$rowCount]."</td> 
									<td>".$order_details['delivery_address'.$rowCount]."</td>
									<td>".$order_details['order_datetime'.$rowCount]."</td> 
									<td align='center'><input type='checkbox' name='app_check".$rowCount."' id='app_check".$rowCount."' onClick='approve(".$rowCount.");'></td>
									<input type='hidden' name='refId".$rowCount."' id='refId".$rowCount."' value='".$order_details['order_id'.$rowCount]."'>
								</tr> ";
			$rowCount += 1;		
			$i += 1;			
		}
		
		
				
		$m_out = $m_out."</table>";						
											
	} else {
		$m_out = $m_out."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='body'> ".
				 " <tr>  ".
				 "	<td>&nbsp;</td> ".
				 " </tr> ".		
				 " <tr height='20'>  ".
				 "	<td align='center'>No Records Found!</td> ".
				 " </tr> ".
				 " <tr>  ".
				 "	<td>&nbsp;</td> ".
				 " </tr> ".				 
				 "</table>";
	}
	echo $m_out;		
}

if($m_chksql == "generate_order_shipped_mail"){

	$id = $_GET['id'];

	$details = array();	
    $details = $orderObj -> loadOrderDetailsById($id);

 	$html = "";
	require_once("order_shipped_mail.tpl.php");
	$html = $order_shipped_mail;			
		
	$final_msg = $mailObj -> prepareHtmlMail($html);
	$subject = 'PhoneRepairParts.co.nz Order Shipped.';
		
	if (mail($details['email'], $subject, $final_msg['multipart'], $final_msg['headers'])) {			
		echo "Email sent Successfully!";
	} else {
		echo "Message delivery failed!";
	}		
}

?>

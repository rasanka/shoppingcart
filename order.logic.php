<?php 

	session_start();

    require_once("order.class.php");
	require_once("cart.class.php");
    require_once("logger.class.php");
    require_once ("mail_logic.class.php");

    $orderObj = new Order();
	$cartObj = new Cart();
    $logObj = new Logger();
    $mailObj = new MailLogic();

    if($_GET['check'] == "place_order") {

        $cart_id = $_SESSION['sitcart'];
        $user_id = $_SESSION['sitid'];

        $bill_fname = $_POST['billFName'];
        $bill_lname = $_POST['billLName'];
        $bill_company = $_POST['billCompany'];
        $bill_email = $_POST['billEmail'];
        $bill_contact = $_POST['billPhone'];
        $bill_house_no = $_POST['billHouse'];
        $bill_street = $_POST['billStreet'];
        $bill_city = $_POST['billCity'];
        $bill_region = $_POST['billRegion'];
        $bill_country = $_POST['billCountry'];
        $bill_postal = $_POST['billPostal'];

        $billing_name = $bill_fname." ".$bill_lname;
        $billing_addr = $bill_house_no.", ".$bill_street.", ".$bill_city.", ".$bill_region.", ".$bill_country.", ".$bill_postal;
        //$logObj -> logData('BILLIN ADDR -'.$billing_addr);

        $deli_fname = $_POST['delvFName'];
        $deli_lname = $_POST['delvLName'];
        $deli_company = $_POST['delvCompany'];
        $deli_email = $_POST['delvEmail'];
        $deli_contact = $_POST['delvPhone'];
        $deli_house_no = $_POST['delvHouse'];
        $deli_street = $_POST['delvStreet'];
        $deli_city = $_POST['delvCity'];
        $deli_region = $_POST['delvRegion'];
        $deli_country = $_POST['delvCountry'];
        $deli_postal = $_POST['delvPostal'];
        $deli_note = $_POST['delvNote'];
        $payment_method = $_POST['optionsRadios'];

        $delivery_name = $deli_fname." ".$deli_lname;
        $delivery_addr = $deli_house_no.", ".$deli_street.", ".$deli_city.", ".$deli_region.", ".$deli_country.", ".$deli_postal;

        $cart_tot_array = $cartObj -> getCartTotal($cart_id);
        $cart_total = $cart_tot_array['cart_total'];

        $tax_amount = 0;//(7 / 100) * $cart_total;
        $order_total = floatval($cart_total + $tax_amount);

        $order_id = 0;
        $order_id = $orderObj -> createOrder($cart_id, $user_id, $cart_total, $tax_amount, $order_total, $billing_name, $bill_company, $bill_email, $bill_contact, $billing_addr,$delivery_name, $deli_company, $deli_email, $deli_contact, $delivery_addr, $deli_note, $payment_method, 'PENDING_PAYMENT');

        $msg = '';
        if($order_id > 0) {
            // Creating a session object to track the order
            $_SESSION['sitorder'] = $order_id;
          
            // Updating the cart status - PROCESSING
            $cart_status = $cartObj -> updateCartStatus($cart_id,'PROCESSED');

            if($payment_method == "BANK") {
                // Generate Mail with BANK account details and receipt upload process
                require_once("bank_payment_mail.tpl.php");

                $html = $bank_payment_mail;
                $final_msg = $mailObj -> prepareHtmlMail($html);
                $subject = 'Bank deposit details for your order with PhoneRepairParts.co.nz';
                    
                if (mail($bill_email, $subject, $final_msg['multipart'], $final_msg['headers'])) {
                    $logObj -> logData('Bank details mail sent to '.$bill_email.' for Order # -'.$order_id);
                } else {
                    $logObj -> logData('Error occured while sendin the Bank details mail to '.$bill_email.' for Order # -'.$order_id);
                }

            }
            
        } 
        echo $order_id;
    }

?>
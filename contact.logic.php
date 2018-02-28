<?php 

    require_once("newsletter.class.php");
    require_once ("mail_logic.class.php");
    require_once ("logger.class.php");

    $newsLetterObj = new NewsLetter();
    $mailObj  = new MailLogic();
    $logObj = new Logger();

    if(isset($_POST['contact'])) {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $company = $_POST['company'];
        $message = $_POST['message'];
        
        $result = $newsLetterObj -> saveContactUsInquiry($name,$company,$email,$subject,$message);

        $msg = '';
        $msg_type = '';
        if($result){
        
            require_once("contact_us_mail.tpl.php");
            
            $html = $contact_us_mail;

            //$logObj -> logData($html);
            
            $final_msg = $mailObj -> prepareHtmlMail($html);
            $subject = 'Thank you for contacting PhoneRepairParts.co.nz';

             //$logObj -> logData('FINAL MULTI --------------------'.$final_msg['multipart']);

             //$logObj -> logData('FINAL MULTI --------------------'.$final_msg['headers']);
                
            if (mail($email, $subject, $final_msg['multipart'], $final_msg['headers'])) {
                $msg_type = "alert-success";
                $msg = "Thank you for your response. We will be in touch with you within 24 hours.";
                
                require_once("inquiry_mail.tpl.php");
                
                $inq_html = $inquiry_mail;
                
                $final_msg = $mailObj -> prepareHtmlMail($inq_html);
                $subject = 'Inquiry about PhoneRepairParts.co.nz';
                    
                mail("inquiry@phonerepairparts.co.nz", $subject, $final_msg['multipart'], $final_msg['headers']);			
                
            } else {
                $msg = "Message delivery failed!";
                $msg_type = "alert-warning";
            }	
        }

        echo "
            <div class='alert ".$msg_type."'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>".$msg."</b>
            </div> "; 

    }         

?>
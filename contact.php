    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Contact Us</li>
            </ol>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4>CONTACT US</h4>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 hidden-xs"><span class="font-size"> <a href="#">-</a> <i class="fa fa-font"></i> <a href="#">+</a></span></div>
          <!-- end col-4 -->
        </div>
      </div>
    </section>  
   
<!-- start contact section -->
 <section id="aa-contact">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="aa-contact-area">
           <div class="aa-contact-top">
             <h2>We are wating to assist you..</h2>
             <p>PhoneRepairParts.co.nz, smart-phone's-tablets-laptops!</p>
           </div>
           <!-- contact map -->
           <div class="aa-contact-map">
              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6383.934226320705!2d174.77702700000003!3d-36.867206!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6d0d4876976edba5%3A0x83d4d6d9608548f0!2s432+Khyber+Pass+Rd%2C+Newmarket%2C+Auckland+1023%2C+New+Zealand!5e0!3m2!1sen!2sin!4v1519024571929" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
           </div>
           <!-- Contact address -->
           
           <div class="aa-contact-address">
             <div class="row">
                <div class="col-md-12" id="message_div">
                    <!-- Message -->
                </div>   
             </div>
             <div class="row">
               <div class="col-md-8">
            
                 <div class="aa-contact-address-left">
                   <form id="contactForm" class="comments-form contact-form" action="">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">                        
                          <input type="text" id="name" name="name" placeholder="Your Name" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">                        
                          <input type="email" id="email" name="email" placeholder="Email" class="form-control">
                        </div>
                      </div>
                    </div>
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">                        
                          <input type="text" id="subject" name="subject" placeholder="Subject" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">                        
                          <input type="text" id="company" name="company" placeholder="Company" class="form-control">
                        </div>
                      </div>
                    </div>                  
                     
                    <div class="form-group">                        
                      <textarea id="message" name="message" class="form-control" rows="3" placeholder="Message"></textarea>
                    </div>
                    <button type="submit" class="aa-secondary-btn">Send</button>
                  </form>
                 </div>
               </div>
               <div class="col-md-4">
                 <div class="aa-contact-address-right">
                   <address>
                     <h4><b>PhoneRepairParts.co.nz</b></h4>
                     <p><b>smart-phone's-tablets-laptops</b></p>
                     <p><span class="fa fa-home"></span>432 Kyber Pass Road,</p> 
                     <p>Newmarket,</p> 
                     <p>Auckland 1023, </p> 
                     <p>New Zealand.</p>
                     
                     <p><span class="fa fa-phone"></span>09 574 5298</p>
                     <p><span class="fa fa-phone"></span>021 164 6511</p>                     
                     <p><span class="fa fa-envelope"></span>Email: info@phonerepairparts.co.nz</p>
                   </address>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrapValidator.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
  
  $('#contactForm').bootstrapValidator({
        
        fields: {

            name: {
                validators: {
                    notEmpty: {
                        message: 'The Name is required and cannot be empty'
                    }
                }
            },          
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },  
            subject: {
                validators: {
                    notEmpty: {
                        message: 'The Subject is required and cannot be empty'
                    }
                }
            },    
            message: {
                validators: {
                    notEmpty: {
                        message: 'The Message is required and cannot be empty'
                    }
                }
            },            
        },
        
        submitHandler: function(validator, form, submitButton) {
          var name = validator.getFieldElements('name').val();
          var email = validator.getFieldElements('email').val();
          var subject = validator.getFieldElements('subject').val();
          var company = $('#company').val()
          var message = validator.getFieldElements('message').val();
          
          $.ajax({
            url : "contact.logic.php",
            method : "POST",
            data : {contact:1,name:name,email:email,subject:subject,company:company,message:message},
            success : function(data){
              $('#message_div').html(data);
            }
          });
        }
    });

});

</script>   
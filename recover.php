    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Forgot Password</li>
            </ol>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4>RECOVER PASSWORD</h4>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 hidden-xs"><span class="font-size"> <a href="#">-</a> <i class="fa fa-font"></i> <a href="#">+</a></span></div>
          <!-- end col-4 -->
        </div>
      </div>
    </section>  

 <!-- Cart view section -->
 <section id="aa-myaccount">
   <div class="container">
     <div class="row">
       <div class="col-md-12" id="message_div">
            <!-- Message -->
       </div>
       <div class="col-md-12">
        <div class="aa-myaccount-area">
        <form id="recoverForm" method="POST" class="form-horizontal aa-login-form">
        <!--<div class="aa-myaccount-area"> -->        
            <div class="row">
              <div class="col-md-12">
              	 <h4>Request Password</h4>

                    <br/>
                    <br/>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Email address</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="reg_email" id="reg_email" placeholder="Email" value="<?php echo $_GET['email']; ?>" />
                        </div>
                    </div>
                                    
                                       
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn btn-primary">Send Password</button>
                        </div>
                    </div>

                    <br/>
                    <br/>
                    <br/>                    
                                                
              </div>
              
              
            </div>          
         <!--</div>-->
         </form>
        </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->
 
 <script src="js/jquery.min.js"></script>
 <script src="js/bootstrapValidator.min.js"></script>
 <script type="text/javascript">
 
 
$(document).ready(function() {
    $('#recoverForm').bootstrapValidator({
        
        fields: {
            reg_email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },			
        },
        
        submitHandler: function(validator, form, submitButton) {
             $.ajax({
                url : "user.logic.php?check=recover",
                method : "POST",
                data : $("form").serialize(),
                success : function(data){
                    $('#message_div').html(data);
                }
            });
        }
    });
}); 
</script>

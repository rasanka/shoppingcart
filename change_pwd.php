<?php if(isset($_SESSION['sitid'])) { ?>
   
    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Change Password</li>
            </ol>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4>CHANGE PASSWORD</h4>
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
        <form id="changePwdForm" method="POST" class="form-horizontal aa-login-form">
        <!--<div class="aa-myaccount-area"> -->        
            <div class="row">
              <div class="col-md-6">
              	 <h4>Change Password</h4>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Old Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old password" />
                        </div>
                    </div>
                           
                    <div class="form-group">
                        <label class="col-md-3 control-label">New Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New password" />
                        </div>
                    </div>
                                                                                                 
                    <div class="form-group">
                        <label class="col-md-3 control-label">Re-Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Re-type password" />
                        </div>
                    </div>
              
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </div>
                                   
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
    $('#changePwdForm').bootstrapValidator({

        fields: {

			old_password: {
				validators: {
					notEmpty: {
						message: 'The Old password is required and can\'t be empty'
					},
				}
			},		
			new_password: {
				validators: {
					notEmpty: {
						message: 'The New password is required and can\'t be empty'
					},
                    identical: {
						field: 'confirmPassword',
						message: 'The New password and its confirm are not the same'
					}
				}
			},
			confirmPassword: {
				validators: {
					notEmpty: {
						message: 'The confirm password is required and can\'t be empty'
					},
					identical: {
						field: 'new_password',
						message: 'The New password and its confirm are not the same'
					}
				}
			},	
			           				
        },
        
        submitHandler: function(validator, form, submitButton) {
             $.ajax({
                url : "user.logic.php?check=change_pwd",
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
<?php } else { ?>

<script src="js/jquery.min.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
    window.location.href='index.php?page=account';
  });

</script>

<?php } ?>
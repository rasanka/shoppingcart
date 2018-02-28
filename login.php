  <!-- Login Modal -->  
  <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">                      
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4>Login or Register</h4>
          <div class="col-md-12" id="login_message_div">
            <!-- Message -->
          </div>
          <form id="loginForm" action="" class="aa-login-form">
          
            <div class="form-group">
              <label class="control-label">Email address<span>*</span></label>
              <input class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-group">
              <label class="control-label">Password<span>*</span></label>
              <input class="form-control" type="password" name="password" id="password" placeholder="Password">
            </div>
            <label for="rememberme" class="rememberme"><input type="checkbox" id="rememberme"> Remember me </label>
            <button class="btn btn-primary" type="submit">Login</button>
            
            <p class="aa-lost-password"><a href="index.php?page=recover">Forgot your password?</a></p>
            <div class="aa-register-now">
              Don't have an account?<a href="index.php?page=register">Register now!</a>
            </div>
          </form>
        </div>                        
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>   

<script src="js/jquery.min.js"></script>
<script src="js/bootstrapValidator.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
  
 $('#loginForm').bootstrapValidator({
        
        fields: {
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
            password: {
              validators: {
                notEmpty: {
                  message: 'The password is required and can\'t be empty'
                },
              }
            },                
        },
        
        submitHandler: function(validator, form, submitButton) {
          var email = validator.getFieldElements('email').val();
          var password = validator.getFieldElements('password').val();
         
          $.ajax({
            url : "login.logic.php",
            method : "POST",
            data : {validate:1,userEmail:email,userPassword:password},
            success : function(data){
              if (data.includes('OK')) {
                window.location.href='index.php';
              } else {
                $('#login_message_div').html(data);
              }
            }
          });
        }
    });

});

</script>  
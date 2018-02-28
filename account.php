    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Account</li>
            </ol>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4>ACCOUNT</h4>
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
        <?php if(!isset($_SESSION['sitid'])) { ?>
        <div class="aa-myaccount-area">         
            <div class="row">
              <div class="col-md-6">
                <div class="aa-myaccount-login">
                <h4>Login</h4>
                 <form id="loginForm" action="" class="aa-login-form">
                  <div class="form-group">
                    <label class="control-label">Email address<span>*</span></label>
                    <input class="form-control" id="login_email" name="login_email" type="text" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <label class="control-label">Password<span>*</span></label>
                    <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                  </div>
                  <button type="submit" class="aa-browse-btn">Login</button>
                  <label class="rememberme" for="rememberme"><input type="checkbox" id="rememberme"> Remember me </label>
                  <p class="aa-lost-password"><a href="index.php?page=recover">Forgot your password?</a></p>
                  </form>
                </div>
              </div>
              <div class="col-md-6">
                <div class="aa-myaccount-register">                 
                 <h4>Register</h4>
                  <form id="registrationForm" action="" class="aa-login-form">

                    <div class="form-group">
                      <label class="control-label">Email address<span>*</span></label>
                      <input class="form-control" type="text" id="reg_email" name="reg_email" placeholder="Email">
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>                   
                  </form>
                </div>
              </div>
            </div>          
         </div>
         <?php } ?>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->

<script src="js/jquery.min.js"></script>
<script src="js/bootstrapValidator.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {

  $('#loginForm').bootstrapValidator({

        fields: {
            login_email: {
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
          var email = validator.getFieldElements('login_email').val();
          var password = validator.getFieldElements('password').val();
          //window.location.href='index.php?page=register&email='+$('#reg_email').val();
          $.ajax({
            url : "login.logic.php",
            method : "POST",
            data : {validate:1,userEmail:email,userPassword:password},
            success : function(data){
              if (data.includes('OK')) {
                window.location.href='index.php';
              } else {
                $('#message_div').html(data);
              }
            }
          });
        }
  });



  $('#registrationForm').bootstrapValidator({       
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
      window.location.href='index.php?page=register&email='+$('#reg_email').val();
    }
  });

});

</script>
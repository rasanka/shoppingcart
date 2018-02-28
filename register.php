    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Register</li>
            </ol>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4>REGISTER</h4>
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
        <form id="registrationForm" method="POST" class="form-horizontal aa-login-form">
        <!--<div class="aa-myaccount-area"> -->        
            <div class="row">
              <div class="col-md-6">
              	 <h4>My Account</h4>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Email address</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="reg_email" id="reg_email" placeholder="Email" value="<?php echo $_GET['email']; ?>" />
                        </div>
                    </div>
                                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Full Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="firstName" id="firstName" placeholder="First Name" />
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Last Name" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Contact No</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="contact" id="contact" placeholder="Contact No" />
                        </div>
                    </div>
                           
                    <div class="form-group">
                        <label class="col-md-3 control-label">Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="reg_password" id="reg_password" placeholder="Password" />
                        </div>
                    </div>
                                                                          
                       
                    <div class="form-group">
                        <label class="col-md-3 control-label">Re-Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Re-type password" />
                        </div>
                    </div>
                                              
                	<div class="form-group">
                        <div class="col-xs-8 col-xs-offset-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="agree" value="agree" /> <a data-toggle="modal" data-target="#termsModal">Agree with the terms and conditions</a>
                                </label>
                            </div>
                        </div>
                    </div>                                       
                                       
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                               
              </div>
              
              <div class="col-md-6">
              	 <h4>Billing Address</h4>
                 
                    <div class="form-group">
                        <label class="col-md-3 control-label">House/Unit #</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="houseNo" id="houseNo" placeholder="House / Unit No." />
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label class="col-md-3 control-label">Street</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="street" id="street" placeholder="Street Name" />
                        </div>
                    </div>
                              
                    <div class="form-group">
                        <label class="col-md-3 control-label">City</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="city" id="city" placeholder="Ex: Huntingdale" />
                        </div>
                    </div>     

                    <div class="form-group">
                        <label class="col-md-3 control-label">Region</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="region" id="region" placeholder="Ex: Western Australia" />
                        </div>
                    </div>                                                      
                   
                          
                    <div class="form-group">
                        <label class="col-md-3 control-label">Postal Code</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="postalCode" id="postalCode" placeholder="Postal code" />
                        </div>
                    </div>
                      
                    <div class="form-group">
                        <label class="col-md-3 control-label">Country</label>
                        <div class="col-md-8">
                              <div class="aa-checkout-country">
                                <select name="country" id="country">
                                  <option value="-">Select Your Country</option>
                                  <option value="AUS" selected="true">Australia</option>                                  
                                </select>
                              </div>                                                         
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
            firstName: {
                validators: {
                    notEmpty: {
                        message: 'The first name is required and cannot be empty'
                    }
                }
            },
            lastName: {
                validators: {
                    notEmpty: {
                        message: 'The last name is required and cannot be empty'
                    }
                }
            },
            contact: {
                validators: {
                    notEmpty: {
                        message: 'The contact number is required and cannot be empty'
                    },
					stringLength: {
                        min: 6,
                        max: 12,
                        message: 'The contact no must be more than 6 and less than 12 characters long'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'The contact no can only consist of numbers'
                    }					
                }
            },			
			reg_password: {
				validators: {
					notEmpty: {
						message: 'The password is required and can\'t be empty'
					},
                    identical: {
						field: 'confirmPassword',
						message: 'The password and its confirm are not the same'
					}
				}
			},
			confirmPassword: {
				validators: {
					notEmpty: {
						message: 'The confirm password is required and can\'t be empty'
					},
					identical: {
						field: 'reg_password',
						message: 'The password and its confirm are not the same'
					}
				}
			},	
			
			agree: {
				validators: {
					notEmpty: {
						message: 'Please agree with terms and conditions'
					},
				}
			},		

            houseNo: {
                validators: {
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'The house no can only consist of numbers'
                    }                   
                }
            },            				
        },
        
        submitHandler: function(validator, form, submitButton) {
             $.ajax({
                url : "user.logic.php?check=register",
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

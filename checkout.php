
<?php if(isset($_SESSION['sitid'])) { ?>

    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Checkout</li>
            </ol>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4>CHECKOUT</h4>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 hidden-xs"><span class="font-size"> <a href="#">-</a> <i class="fa fa-font"></i> <a href="#">+</a></span></div>
          <!-- end col-4 -->
        </div>
      </div>
    </section>  


<?php 

  $cart_id = $_SESSION['sitcart'];
  $user_id = $_SESSION['sitid'];

  require_once("cart.class.php");
  require_once("user.class.php");
  require_once("item.class.php");
  require_once("logger.class.php");

  $cartObj = new Cart();
  $userObj = new User();
  $itemObj = new Item();
  $logger = new Logger();

  $userDetails = $userObj -> getUserDetailsById($user_id);

  $cart_array = array();
  $cart_array = $cartObj -> loadCartByUserId($user_id);
 
  //$logger -> logData('OK');
?>

 <!-- Cart view section -->
 <section id="checkout">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="checkout-area">

         <?php if(count($cart_array) > 0) { ?>
          <form id="checkoutForm"  method="POST" action="javascript:return;">
            <div class="row">
              <div class="col-md-8">
                <div class="checkout-left">
                  <div class="panel-group" id="accordion">
                    <!-- Billing Details -->
                    <div class="panel panel-default aa-checkout-billaddress">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            Billing Details
                          </a>
                        </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse in">
                        <div class="panel-body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="First Name*" id="billFName" name="billFName" class="form-control" value="<?php echo $userDetails['fname']; ?>">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="Last Name*" id="billLName" name="billLName" class="form-control" value="<?php echo $userDetails['lname']; ?>">
                              </div>
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Company name" id="billCompany" name="billCompany" >
                              </div>                             
                            </div>                            
                          </div>  
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="email" placeholder="Email Address*" id="billEmail" name="billEmail" class="form-control" value="<?php echo $userDetails['email']; ?>">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="tel" placeholder="Phone*" id="billPhone" name="billPhone" class="form-control" value="<?php echo $userDetails['contact']; ?>">
                              </div>
                            </div>
                          </div>  
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="House/Unit No." id="billHouse" name="billHouse" class="form-control" value="<?php echo $userDetails['bill_house_no']; ?>">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="Street Name*" id="billStreet" name="billStreet" class="form-control" value="<?php echo $userDetails['bill_street']; ?>">
                              </div>
                            </div>
                          </div>   
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="City*" id="billCity" name="billCity" class="form-control" value="<?php echo $userDetails['bill_city']; ?>">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="Suburb*" id="billRegion" name="billRegion" class="form-control" value="<?php echo $userDetails['bill_region']; ?>">
                              </div>
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <select id="billCountry" name="billCountry" class="form-control">
                                  <option value="NZ" selected>New Zealand</option>
                                </select>                                
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="Postcode*" id="billPostal" name="billPostal" class="form-control" value="<?php echo $userDetails['bill_postal_code']; ?>">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <input type="checkbox" class="populate-delivery-addr" id="sameAsBilling" name="sameAsBilling">  Delivery address is same as Billing address
                            </div>
                          </div>                        
                                                            
                        </div>
                      </div>
                    </div>
                    <!-- Shipping Address -->
                    <div class="panel panel-default aa-checkout-billaddress">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" id="deliveryTrigger" data-parent="#accordion" href="#collapseFour">
                            Delivery Address
                          </a>
                        </h4>
                      </div>
                      <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="First Name*" id="delvFName" name="delvFName" class="form-control" value="">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="Last Name*" id="delvLName" name="delvLName" class="form-control" value="">
                              </div>
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Company name" id="delvCompany" name="delvCompany" >
                              </div>                             
                            </div>                            
                          </div>  
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="email" placeholder="Email Address*" id="delvEmail" name="delvEmail" class="form-control" value="">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="tel" placeholder="Phone*" id="delvPhone" name="delvPhone" class="form-control" value="">
                              </div>
                            </div>
                          </div>  
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="House/Unit No." id="delvHouse" name="delvHouse" class="form-control" value="">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="Street Name*" id="delvStreet" name="delvStreet" class="form-control" value="">
                              </div>
                            </div>
                          </div>   
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="City / Town*" id="delvCity" name="delvCity" class="form-control" value="">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="Region*" id="delvRegion" name="delvRegion" class="form-control" value="">
                              </div>
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <select id="delvCountry" name="delvCountry" class="form-control">
                                  <option value="NZ" selected>New Zealand</option>
                                </select>                                
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="form-group aa-checkout-single-bill">
                                <input type="text" placeholder="Postcode / ZIP*" id="delvPostal" name="delvPostal" class="form-control" value="">
                              </div>
                            </div>
                          </div>

                           <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <textarea cols="8" rows="3" id="delvNote" name="delvNote">Special Notes</textarea>
                              </div>                             
                            </div>                            
                          </div>              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="checkout-right">
                  <h4>Order Summary</h4>
                  <div class="aa-order-summary-area">
                    <table class="table table-responsive">
                      <thead>
                        <tr>
                          <th>Product</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php 

                      $cart_array = array();
                      $cart_array = $cartObj -> loadCartById($cart_id);

                      $cart_summary = "";
                      $cart_items_html = "";
                      $cart_item_count = 0;     

                      $delivery_arr = array();    
            
                      if(count($cart_array) > 0){
                                  
                          //$cart_id = $cart_array['cart_id'];
                          $total_price = $cart_array['total_price'];

                          $item_array = array();
                          $item_array = $cartObj -> loadCartItemsById($cart_id);                        

                          $j = 0;
                          $itemCount = 1;
                          $cart_item_count = (count($item_array)/3);
                          while($j < $cart_item_count){

                              $prod_id = $item_array['prod_id'.$itemCount];
                              $prod_qty = $item_array['qty'.$itemCount];

                              //$total_item_count  += $prod_qty; 

                              $prod_array = array();
                              $prod_array = $itemObj -> loadItemByID($prod_id); 

                              if(count($prod_array) > 0){

                                  $item_total = ($prod_qty * $prod_array['item_price']);
                                  $delivery = $prod_array['delivery'];
                                  array_push($delivery_arr, $delivery);
                                      
                                  echo "
                                      <tr>
                                        <td><a href='index.php?page=product&pid=".$prod_id."'>".$prod_array['item_name']."</a> <strong> x  ".$prod_qty."</strong></td>
                                        <td>$".$item_total."</td>
                                      </tr>                        
                                      ";
                              }

                              $itemCount += 1;
                              $j +=1;
                          }              
                      }

                      $delivery_amount = max($delivery_arr);//(7 / 100) * $total_price;
                      
                      ?>

                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Subtotal</th>
                          <td>$<?php echo $total_price; ?></td>
                        </tr>
                         <tr>
                          <th>Delivery</th>
                          <td>$<?php echo $delivery_amount; ?></td>
                          <input type="hidden" name="delivery_amt" id="delivery_amt" value="<?php echo $delivery_amount; ?>" />
                        </tr>
                         <tr>
                          <th>Total</th>
                          <td>$<?php echo ($total_price + $delivery_amount); ?></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <h4>Payment Method</h4>
                  <div class="aa-payment-method">                    
                    <label for="banktransfer"><input type="radio" id="banktransfer" name="optionsRadios" value="BANK" checked> Bank Transfer </label>
                    <!--<label for="cashdelivery"><input type="radio" id="cashdelivery" name="optionsRadios" value="CASH" disabled> Cash on Delivery </label>-->
                    <label for="paypal"><input type="radio" id="paypal" name="optionsRadios" value="PAYPAL" disabled> Via Paypal </label>
                    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark">    

                    <?php 
                      require_once("order.class.php");
                      $orderObj = new Order();

                      $order_count = 0;
                      if(isset($_SESSION['sitorder'])) {
                        $order_id = $_SESSION['sitorder'];
                        $check_array = $orderObj -> isSameOrder($order_id, $cart_id);
                        $order_count = $check_array['same_order'];
                      }  

                      if($order_count == 0) {
                    ?>  
                      <input id="submitButton" name="submitButton" type="submit" value="Place Order" class="aa-browse-btn">                
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </form>

          <?php } else { ?>

            <div class='col-md-12' id='message_div'>
              <div class='alert alert-warning'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>No Product added to the Cart!</b>
              </div>    
              <br/>
              <br/>
              <br/>
              <br/>
              <br/>
              <br/>    
              <br/>
              <br/>
              <br/>
              <br/>            
            </div>

          <?php } ?>

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

  var submitCount = 0;

  $("body").delegate(".populate-delivery-addr","click", function(event){
    //event.preventDefault();
      $('#delvFName').val($('#billFName').val());
      $('#delvLName').val($('#billLName').val());
      $('#delvEmail').val($('#billEmail').val());
      $('#delvPhone').val($('#billPhone').val());
      $('#delvHouse').val($('#billHouse').val());
      $('#delvStreet').val($('#billStreet').val());
      $('#delvCity').val($('#billCity').val());
      $('#delvRegion').val($('#billRegion').val());
      $('#delvPostal').val($('#billPostal').val());
      $("#checkoutForm").data('bootstrapValidator').resetForm();
   });  

   $('#checkoutForm').bootstrapValidator({
        excluded: false,
        fields: {		
            billFName: {
                validators: {
                    notEmpty: {
                        message: 'The First name is required and cannot be empty'
                    }
                }
            },
            billLName: {
                validators: {
                    notEmpty: {
                        message: 'The Last name is required and cannot be empty'
                    }
                }
            },
            billEmail: {
                validators: {
                    notEmpty: {
                        message: 'The Email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },  
            billPhone: {
                validators: {
                    notEmpty: {
                        message: 'The Phone number is required and cannot be empty'
                    }
                }
            },
            billHouse: {
                validators: {
                    notEmpty: {
                        message: 'The House# is required and cannot be empty'
                    }
                }
            },  
            billStreet: {
                validators: {
                    notEmpty: {
                        message: 'The Street is required and cannot be empty'
                    }
                }
            }, 
            billCity: {
                validators: {
                    notEmpty: {
                        message: 'The City is required and cannot be empty'
                    }
                }
            }, 
            billRegion: {
                validators: {
                    notEmpty: {
                        message: 'The Region is required and cannot be empty'
                    }
                }
            }, 
            billPostal: {
                validators: {
                    notEmpty: {
                        message: 'The Postal Code is required and cannot be empty'
                    }
                }
            },
            delvFName: {
                validators: {
                    callback: {
                        message: 'The First name is required and cannot be empty',
                        callback: function ($field, validator) {
                          if($field == "") {
                            $('#deliveryTrigger').click();
                            return false;     
                          } else {
                            return true;
                          }                     
                        }
                    }
                }
            },
            delvLName: {
                validators: {
                    callback: {
                        message: 'The Last name is required and cannot be empty',
                        callback: function ($field, validator) {
                          if($field == "") {
                            $('#deliveryTrigger').click();
                            return false;     
                          } else {
                            return true;
                          }                     
                        }
                    }                    
                }
            },
            delvEmail: {
                validators: {
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    },
                    callback: {
                        message: 'The Email is required and cannot be empty',
                        callback: function ($field, validator) {
                          if($field == "") {
                            $('#deliveryTrigger').click();
                            return false;     
                          } else {
                            return true;
                          }                     
                        }
                    }                    
                }
            },  
            delvPhone: {
                validators: {
                    callback: {
                        message: 'The Phone number is required and cannot be empty',
                        callback: function ($field, validator) {
                          if($field == "") {
                            $('#deliveryTrigger').click();
                            return false;     
                          } else {
                            return true;
                          }                     
                        }
                    }                      
                }
            },
            delvHouse: {
                validators: {
                    callback: {
                        message: 'The House# is required and cannot be empty',
                        callback: function ($field, validator) {
                          if($field == "") {
                            $('#deliveryTrigger').click();
                            return false;     
                          } else {
                            return true;
                          }                     
                        }
                    }                     
                }
            },  
            delvStreet: {
                validators: {
                    callback: {
                        message: 'The Street is required and cannot be empty',
                        callback: function ($field, validator) {
                          if($field == "") {
                            $('#deliveryTrigger').click();
                            return false;     
                          } else {
                            return true;
                          }                     
                        }
                    }                      
                }
            }, 
            delvCity: {
                validators: {
                    callback: {
                        message: 'The City is required and cannot be empty',
                        callback: function ($field, validator) {
                          if($field == "") {
                            $('#deliveryTrigger').click();
                            return false;     
                          } else {
                            return true;
                          }                     
                        }
                    }                         
                }
            }, 
            delvRegion: {
                validators: {
                    callback: {
                        message: 'The Region is required and cannot be empty',
                        callback: function ($field, validator) {
                          if($field == "") {
                            $('#deliveryTrigger').click();
                            return false;     
                          } else {
                            return true;
                          }                     
                        }
                    }                    
                }
            }, 
            delvPostal: {
                validators: {
                    callback: {
                        message: 'The Postal code is required and cannot be empty',
                        callback: function ($field, validator) {
                          if($field == "") {
                            $('#deliveryTrigger').click();
                            return false;     
                          } else {
                            return true;
                          }                     
                        }
                    }
                }
            }
        },
        submitHandler: function(validator, form, submitButton) {
            if(submitCount++ == 0) {
              $.ajax({
                  url : "order.logic.php?check=place_order",
                  method : "POST",
                  data : $("form").serialize(),
                  success : function(data){
                      $('.aa-cart-notify').html(0);
                      window.location.href='index.php?page=summary&oid='+data;
                      //$('#message_div').html(data);
                  }
              });  
            }
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
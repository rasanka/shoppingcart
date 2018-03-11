
<?php if(isset($_SESSION['sitid']) && isset($_GET['oid'])) { ?>

<link rel="stylesheet" type="text/css" href="css/uploadstyles.css" />
<script type="text/javascript" src="admin/javascript/ajaxupload.3.5.js" ></script>

    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Summary</li>
            </ol>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4>ORDER SUMMARY</h4>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 hidden-xs"><span class="font-size"> <a href="#">-</a> <i class="fa fa-font"></i> <a href="#">+</a></span></div>
          <!-- end col-4 -->
        </div>
      </div>
    </section>  

<?php 

  $order_id = $_GET['oid'];

  require_once('config/config.php');
  require_once('cart.class.php');
  require_once('item.class.php');
  require_once("order.class.php");

  $cartObj = new Cart();
  $itemObj = new Item();
  $orderObj = new Order();

  $order_details = array();
  $order_details = $orderObj -> loadOrderDetailsById($order_id);

  $cart_id = $order_details['cart_id'];
  $user_id = $_SESSION['sitid'];
?>

 <!-- Cart view section -->
 <section id="checkout">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="checkout-area">

            <div class="row">
              <div class="col-md-12">
                <div class="checkout-right">
                  <h4>Order Summary</h4>
                  <div class="aa-order-summary-area">
                    <table class="table">
                      <thead>
                        <tr>
                          <th colspan="2">Product</th>
                          <th>Qty</th>
                          <th>Unit Price</th>
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
                      //$total_item_count  = 0;

                      if(count($cart_array) > 0){
                                  
                          $item_array = array();
                          $item_array = $cartObj -> loadCartItemsById($cart_id);                        

                          $j = 0;
                          $itemCount = 1;
                          $cart_item_count = (count($item_array)/3);
                          while($j < $cart_item_count){

                              $prod_id = $item_array['prod_id'.$itemCount];
                              $prod_qty = $item_array['qty'.$itemCount];

                              $prod_array = array();
                              $prod_array = $itemObj -> loadItemByID($prod_id); 

                              if(count($prod_array) > 0){

                                  $item_total = ($prod_qty * $prod_array['item_price']);

                                  $prod_image = $itemObj -> loadMainItemImage($prod_id);
    
                                  echo "
                                      <tr>
                                        <td><a href='index.php?page=item&pid=".$prod_id."'><img width='100' height='100' src='item_images/".$prod_id."/".$prod_image['image_name']."' alt='img'></a></td>
                                        <td><a href='index.php?page=item&pid=".$prod_id."'>".$prod_array['item_name']."</a></td>
                                        <td>".$prod_qty."</td>
                                        <td>$".$prod_array['item_price']."</td>
                                        <td>$".$item_total."</td>
                                      </tr>                        
                                      ";
                              }

                              $itemCount += 1;
                              $j +=1;
                          }              
                      }
                      ?>

                      </tbody>
                      <tfoot>
                        <tr>                          
                          <th colspan="4">Subtotal</th>
                          <td>$<?php echo $order_details['cart_total']; ?></td>
                        </tr>
                         <tr>
                          <th colspan="4">Delivery</th>
                          <td>$<?php echo $order_details['delivery_amount']; ?></td>
                        </tr>
                         <tr>
                          <th colspan="4">Total</th>
                          <td>$<?php echo $order_details['order_total']; ?></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <h4>Payment Method</h4>
                  <div class="aa-payment-method">                    
                    <label for="banktransfer"><input type="radio" id="banktransfer" name="optionsRadios" value="BANK" checked> Bank Transfer - <?php echo $order_details['order_status']; ?></label>
                    <?php 
                      if($order_details['payment_method'] == "BANK" && $order_details['order_status'] == "PENDING_PAYMENT") {
                        echo "Please deposit $".$order_details['order_total']." to following acount and upload the payment receipt.
                        <br/>
                        <br/>
                        Account Number - ".$ACCOUNT_NO."
                        <br/>
                        Account Name - ".$ACCOUNT_NAME."
                        <br/>
                        Bank Name - ".$BANK_NAME."
                        <br/>
                        Branch Name - ".$BRANCH_NAME."
                        <br/>
                        ";  ?>
                        <br/>
                        <div id="upload" onClick="startUpload();">Upload Deposit Slip</div>
                        <div id="loading_div"></div>
                        <ul id="files" ></ul>
                    <?php } ?>
                    <br/>
                    <!--
                    <label for="cashdelivery"><input type="radio" id="cashdelivery" name="optionsRadios" value="CASH" disabled> Cash on Delivery </label>
                    <br/>
                    <br/>
                    <label for="paypal"><input type="radio" id="paypal" name="optionsRadios" value="PAYPAL" disabled> Via Paypal </label>
                    -->
                  </div>
                  </br>
                  <h4> Billing Details</h4>
                  <div class="aa-order-address-area">
                    <table class="table table-responsive">
                      <tfoot>
                        <tr>
                          <th width="25%">Full Name</th>
                          <td width="75%"><?php echo $order_details['billing_name']; ?></td>
                        </tr>
                        <tr>
                          <th>Company Name</th>
                          <td><?php echo $order_details['billing_company']; ?></td>
                        </tr>
                        <tr>
                          <th>Email</th>
                          <td><?php echo $order_details['billing_email']; ?></td>
                        </tr>
                        <tr>
                          <th>Contact Number</th>
                          <td><?php echo $order_details['billing_contact']; ?></td>
                        </tr>                                                                        
                         <tr>
                          <th>Billing Address</th>
                          <td><?php echo $order_details['billing_address']; ?></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>

                  <h4> Delivery Details</h4>
                  <div class="aa-order-address-area">
                    <table class="table table-responsive">
                      <tfoot>
                        <tr>
                          <th width="25%">Full Name</th>
                          <td width="75%"><?php echo $order_details['delivery_name']; ?></td>
                        </tr>
                        <tr>
                          <th>Company Name</th>
                          <td><?php echo $order_details['delivery_company']; ?></td>
                        </tr>
                        <tr>
                          <th>Email</th>
                          <td><?php echo $order_details['delivery_email']; ?></td>
                        </tr>
                        <tr>
                          <th>Contact Number</th>
                          <td><?php echo $order_details['delivery_contact']; ?></td>
                        </tr>                                                                        
                         <tr>
                          <th>Delivery Address</th>
                          <td><?php echo $order_details['delivery_address']; ?></td>
                        </tr>
                         <tr>
                          <th>Delivery Note</th>
                          <td><?php echo $order_details['delivery_note']; ?></td>
                        </tr>                        
                      </tfoot>
                    </table>
                  </div>

                </div>
              </div>
            </div>
          </form>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->
 
<script src="js/jquery.min.js"></script>
<script type="text/javascript">

	function startUpload(){
		// var paymentStatus = "<?php echo $details["payment"]; ?>";
		// if(paymentStatus != "PENDING"){
			var order_id =  "<?php echo $order_id;?>";	
			//alert(ad_id);
			var btnUpload=$('#upload');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: 'bank_upload.php',
				name: 'uploadfile',
				onSubmit: function(file, ext){
					 if (! (ext && /^(jpg|png|jpeg|gif|pdf|doc)$/.test(ext))){ 
						status.text('Invalid File Type');
						return false;
					}
					this.setData({'vid': order_id});
					document.getElementById("loading_div").innerHTML = "Uploading...<img src='admin/images/loading.gif'>";
				},
				onComplete: function(file, response){
					document.getElementById("loading_div").innerHTML = "";
					if(response.indexOf("success") > -1){
						var files = response.substring(response.indexOf("#")+1,response.length - 1);
						loadFiles(files);
					} else{
						alert(response);
					}
				}
			});	
		// }
	}
	
	function loadFiles(paths){
		var m_files =  '';
		m_files = trim(paths).split('@');	
		document.getElementById("files").innerHTML = "";
		var displayFiles = '';
		//var ad_id =  document.getElementById("hid_upload_id").value;	
		for(i = 0;i<= m_files.length-1; i++){		
			var url = '';
			var name = '';
			url = trim(m_files[i]).replace("./","");
			name = url.substring(url.lastIndexOf("/")+1,url.length);
			displayFiles = displayFiles + "<a href='<?php echo $SERVER_URL; ?>"+url+"'>"+name+"</a><br>";
		}	
		document.getElementById("files").innerHTML = displayFiles;
	}

  function trim(str, chars) {
    return ltrim(rtrim(str, chars), chars);
  }
  
  function ltrim(str, chars) {
    chars = chars || "\\s";
    return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
  }
  
  function rtrim(str, chars) {
    chars = chars || "\\s";
    return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
  }  

</script>


<?php } else { ?>

<script src="js/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
  window.location.href='index.php?page=account';
});

</script>

<?php } ?>
    <section class="int-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Activate Account</li>
            </ol>
          </div>
          <!-- end col-4 -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <h4>ACTIVATE ACCOUNT</h4>
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

       <div class="col-md-12">
        <div class="aa-myaccount-area">  
            <div class="row">
              <div class="col-md-12">

                    <br/>
                    <br/>

                    <?php
                        require_once("config/config.php");
                        if(isset($_GET['id'])) {
                            require_once ("user.class.php");

                            $userObj = new User();

                            $encUserId = $_GET['id'];
                            $userId = base64_decode($encUserId);

                            if(is_numeric($userId)) {
                                $data = $userObj -> getUserDetailsById($userId);
                            } else {
                                $data = "NO_DATA";
                            }
                            
                            if($data == "NO_DATA") {
                                echo "
                                    <div class='alert alert-warning'>
                                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Invalid account. <br/> 
                                        Please <a href='index.php?page=register'>register</a> with PhoneRepairParts.co.nz</b>
                                    </div> ";                                
                            } else if($data['status'] == "ACTIVE") {
                                echo "
                                    <div class='alert alert-success'>
                                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>User already Activated. <br/> 
                                        Please <a href='index.php?page=account'>login</a></b>
                                    </div> ";                                
                            } else {
                                $result = $userObj -> activateUser($userId);
                                if($result) {
                                    echo "
                                        <div class='alert alert-success'>
                                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>User Activated Successfully. <br/> 
                                            Please <a href='index.php?page=account'>login</a></b>
                                        </div> ";

                                } else {
                                    echo "
                                        <div class='alert alert-warning'>
                                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Error occured during activation process. <br/> 
                                            Please <a href='index.php?page=contact'>contact</a> PhoneRepairParts.co.nz</b>
                                        </div> ";
                                }
                            }
                        } else { ?>

                        <script type="text/javascript">
                            window.location.href='index.php?page=404';
                        </script>
                            
                    <?php } ?>

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
                    <br/>
                    <br/>                                                  
              </div>
              
              
            </div>          
        </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->

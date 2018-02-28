  <!-- Subscribe section -->
  <section id="aa-subscribe">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-subscribe-area">

            <div class="col-md-12" id="subscribe_message_div">
                  <!-- Message -->
            </div>

            <h3>Subscribe our newsletter </h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, velit!</p>
            <form id="subscribeForm" action="" class="aa-subscribe-form">
              <div class="form-group">
                <input type="email" name="subscribe_email" id="subscribe_email" class="form-control" placeholder="Enter your Email">
              </div>                
              <input type="submit" value="Subscribe">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Subscribe section -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrapValidator.min.js"></script>
<script type="text/javascript">
 
$(document).ready(function() {
    $('#subscribeForm').bootstrapValidator({
        
        fields: {
            subscribe_email: {
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
                url : "newsletter.logic.php?check=subscribe",
                method : "POST",
                data : $("form").serialize(),
                success : function(data){
                    $('#subscribe_message_div').html(data);
                }
            });
        }
    });
}); 
</script>
  
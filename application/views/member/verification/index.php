<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>BOAME | Web Application</title>
  <meta name="description" content="Boame - People Helping People
We (Boame) are a peer to peer financial community made up of selfless and responsible persons of the same unique goal of bridging the gap between the rich and the poor.

We give good returns on all donations. We provide a state-of-the-art platform for our community to link up with others to Provide and Receive Help from each other. At Boame, you can meet your needs at ease when you receive help from others. Pay for your hospital, utilities and other bills at ease." />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>/animate.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>/icon.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>/font.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>/app.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>/style.css" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>intlTelInput.css" type="text/css"/>  
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>sprite.scss" type="text/scss"/>  
  <style>
  .m-b-lg {
    text-align: center;
  }
  .intl-tel-input {width: 100%;}
  .error{
    color :red;
  }
  </style>
</head>
<body class="mobile_container">
   <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <i class="fa fa-ok-sign"></i><?= $this->session->flashdata('error'); ?>.
    </div>
  <?php endif; ?>
  <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <i class="fa fa-ok-sign"></i><?= $this->session->flashdata('success'); ?>.
      </div>
  <?php endif; ?>
  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xl">
      <a class="navbar-brand block" href="index.html"></a>
      <section class="m-b-lg ph_no_wrap">
        <form  method="post" id="enter_number" action="<?php echo BASE_URL?>verification/callMethod" method="post">
          <img src="<?php echo ADMIN_IMAGES ;?>BOAME-transparent.png" alt="" height="200px" width="200px">
            <header class="wrapper text-center">
              <h5>Verify your phone number</h5>
              <p>We will text a verification code to your phone and then you will enter it to verify your phone.</p>
            </header> 
            <!-- <div class="form-group text-left">
                <input type="text" placeholder="Enter mobile number like +919090909090" class="form-control" name="phone_number" id="phone_number">
            </div> -->
             <div class="form-group text-left">
                <input type="tel" placeholder="" class="form-control" name="phone_number" id="phone_number">
            </div>
            <div id="errordiv"></div>
            <button type="submit" class="btn btn-lg btn-primary btn-block ver_btn">Send Verification Code <i class="fa fa-arrow-right"></i></button>
        </form> 
      </section>
    </div>
  </section>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="<?php echo ADMIN_JS;?>jquery.validate.js"></script>
  <script src="<?php echo ADMIN_JS;?>intlTelInput.js"></script>
  <script src="<?php echo ADMIN_JS;?>data.js"></script>
  <script>
      $("#phone_number").intlTelInput({
        hiddenInput: "full_number",
        utilsScript: "../../assets/js/utils.js"
      });
    
    </script>
  <script>
  jQuery(document).ready(function(){
    
    function get_window_height(){
      var wind_height = jQuery(window).height();
      jQuery(".mobile_container #content .container").css({"height":wind_height});
    }

    jQuery(window).resize(function() {
       get_window_height();
       
      });

      jQuery(document).resize(function() {
        get_window_height();
        
      });
      get_window_height()
      
      $('#phone_number').keypress(function(e){ 
         if (this.value.length == 0 && e.which == 48 ){
            return false;
         }
      });

     $('#enter_number').validate({
        rules: {
            phone_number : { 
                required :true,
            },
        },
        messages: {
            phone_number : {
               required : 'Please enter valid phone number',
            },
        },
         errorPlacement: function(error, element) {
           error.appendTo('#errordiv');
         }  
    });
  });
</script>
<?php $this->load->view('member/verification/script')?>
 </body>
</html>
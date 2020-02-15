<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>BOAME | Web Application</title>
  <meta name="description" content="Boame - People Helping People
We (Boame) are a peer to peer financial community made up of selfless and responsible persons of the same unique goal of bridging the gap between the rich and the poor.

We give good returns on all donations. We provide a state-of-the-art platform for our community to link up with others to Provide and Receive Help from each other. At Boame, you can meet your needs at ease when you receive help from others. Pay for your hospital, utilities and other bills at ease. " />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>/animate.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>/icon.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>/font.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>/app.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>/style.css" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
  .m-b-lg {
    text-align: center;
  }
  </style>
</head>
<body class="verify_container">
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
      <section class="m-b-lg ver_code_wrap">
        <form id="verify_code" action="<?php echo BASE_URL?>verification/verifyMessage" method="post">
          <img src="<?php echo ADMIN_IMAGES ;?>BOAME-transparent.png" alt="" height="200px" width="200px">
            <header class="wrapper text-center">
              <h5 style="color:black">Verify your phone number</h5>
              <p>Enter the verfication code which we sent to your phone.</p>
            </header> 
            <div class="form-group text-left">
                <input type="text" placeholder="please enter verfication code" class="form-control" name="verification_code" id="verification_code">
                <input type="hidden" value="<?php echo $phone_number?>" name="phone_number">
            </div>
            <a href="<?php echo BASE_URL?>verification/callMethod" class="recheck_link">Not getting the code?</a>
            <a href="<?php echo BASE_URL?>verification/loadPage" class="recheck_link">Let's Check the number</a>
          <button type="submit" class="btn btn-lg btn-primary btn-block ver_btn">Verify <i class="fa fa-arrow-right"></i> </button>
        </form>
      </section>
    </div>
  </section>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script>
  jQuery(document).ready(function(){
    
    function get_window_height(){
      var wind_height = jQuery(window).height();
      jQuery(".verify_container #content .container").css({"height":wind_height});
    }
    jQuery(window).resize(function() {
       get_window_height();
       
      });

      jQuery(document).resize(function() {
        get_window_height();
        
      });
      get_window_height()
      
  });
</script>
<?php $this->load->view('member/verification/script')?>
</body>
</html>
<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>BOAME | Web Application</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo ADMIN_IMAGES?>BOAME-transparent.png" />
  <meta name="description" content="Boame - People Helping People
We (Boame) are a peer to peer financial community made up of selfless and responsible persons of the same unique goal of bridging the gap between the rich and the poor.

We give good returns on all donations. We provide a state-of-the-art platform for our community to link up with others to Provide and Receive Help from each other. At Boame, you can meet your needs at ease when you receive help from others. Pay for your hospital, utilities and other bills at ease." />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>animate.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>app.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>style.css" type="text/css" />
  <script src="<?php echo ADMIN_JS ?>jquery.min.js"></script><!--jquery js-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <style>
  .m-b-lg {
    text-align: center;
  }
  </style>
</head>
<body class="reff_container">
  <?php if ($this->session->flashdata('danger')): ?>
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <i class="fa fa-ok-sign"></i><?= $this->session->flashdata('danger'); ?>.
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
      <section class="m-b-lg ref_code_wrap">
        <form  method="post" action="<?= BASE_URL('user/isReferalExist'); ?>">
          <img src="<?php echo ADMIN_IMAGES ;?>BOAME-transparent.png" alt="" height="200px" width="200px">
            <header class="wrapper text-center">
              <h3>Please enter the Referal code to join us</h3>
            </header>    
            <div class="list-group">
              <div class="list-group-item">
                <input type="text" placeholder="please enter referal code" class="form-control" name="referal_code" value="<?php echo isset($referal_code) ? $referal_code : '' ?>">
              </div>
            </div> 
          <button type="submit" class="btn btn-lg btn-primary btn-block reff_btn">Check Referal Code</button>
        </form>
      </section>
     
    </div>
  </section>
  <script>
  jQuery(document).ready(function(){
    
    function get_window_height(){
      var wind_height = jQuery(window).height();
      jQuery(".reff_container #content .container").css({"height":wind_height});
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
</body>
</html>
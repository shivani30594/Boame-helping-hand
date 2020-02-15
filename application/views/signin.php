<!DOCTYPE html>
<html lang="en" class="app sign_container">
<head>  
  <meta charset="utf-8" />
  <title>BOAME | Web Application</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo ADMIN_IMAGES?>BOAME-transparent.png" />
  <meta name="description" content="Boame - People Helping People
We (Boame) are a peer to peer financial community made up of selfless and responsible persons of the same unique goal of bridging the gap between the rich and the poor.

We give good returns on all donations. We provide a state-of-the-art platform for our community to link up with others to Provide and Receive Help from each other. At Boame, you can meet your needs at ease when you receive help from others. Pay for your hospital, utilities and other bills at ease."  />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>animate.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>icon.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>font.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>app.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>style.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>intlTelInput.css" type="text/css"/>  
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>sprite.scss" type="text/scss"/> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
  .m-b-lg {
    text-align: center;
  }
  .btn {
    background-color : #3B5998;
    border: #3B5998;
  }
  .btn:hover {
    background-color : #3B5998;
    border: #3B5998;
  }
    /*29-05-2018*/

#register_form,#login_form{
	display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
  -webkit-box-pack:start;
      -ms-flex-pack:start;
          justify-content:flex-start;
-webkit-box-align:center;
    -ms-flex-align:center;
        align-items:center;
}
.right-form,.left-form{
	-webkit-box-flex:0;
    -ms-flex:0 0 50%;
        flex:0 0 50%;
	max-width:50%;}
.right-form{padding-left:15px;}
.left-form{padding-right:15px;}
.fb-sign-container{text-align:center; width:100%;}
.right-form .list-group-item{margin-bottom:25px;color:red}
.right-form .list-group-item label{
    position:absolute;
    left:0;
    bottom:-24px;
    margin-bottom:0;
}
.intl-tel-input label{bottom:-38px !important; left:-15px !important;}
.fb_sign_up #content{margin:15px auto;}
@media screen and (max-width:620px){
    .right-form,.left-form{
	-webkit-box-flex:0;
    -ms-flex:0 0 100%;
        flex:0 0 100%;
    max-width:100%; padding:0;}
    #register_form,#login_form{
        -ms-flex-wrap:wrap;
    flex-wrap:wrap;
    }
}
@media screen and (max-width:340px){
    .fb_sign_wrap{padding:15px; display:block; margin:15px auto;}
}
/*29-05-2018*/
  </style>
</head>
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
<body class="fb_sign_up">
  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="container fb-sign-container">
      <section class="m-b-lg fb_sign_wrap">
        <form method="post" action="<?php echo BASE_URL?>user/login" name="login_form" id="login_form">
          <div class="left-form">
            <img src="<?php echo ADMIN_IMAGES ;?>BOAME-transparent.png" alt="" height="200px" width="200px">
            <h3> Welcome to BOAME </h3>   
            <h5> BE EMPOWERED, BE RICH</h5>
            <a href="<?php echo $login_url?>" class="btn btn-lg btn-primary fb_btn"><i class="fa fa-fw fa-facebook"></i> Continue With Facebook</a>
          </div>
          <div class="right-form">
            <div class="list-group">
              <div class="list-group-item">
                <input type="email" placeholder="Email" name="email" id="email" class="form-control no-border">
              </div>
              <div class="list-group-item">
                <input type="password" placeholder="Password" class="form-control no-border" name="password" id="password">
              </div>
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
            <div class="line line-dashed"></div>
            <p class="text-muted text-center"><small>New Member? </small><a href="<?php echo BASE_URL?>user/signup" class="">Register Now</a></p>
            <p class="text-muted text-center"><a href="<?php echo BASE_URL?>user/forgot_password" class="">Forgot Password?</a></p>
          </div>
        </form>
      </section>
    </div>
  </section>
  <!-- footer -->
  <footer id="footer">
    <div class="text-center padder">
      <p>
        <!-- <small>BOAME Web Application<br>&copy; 2018</small> -->
      </p>
    </div>
  </footer>

  <script src="<?php echo ADMIN_JS ?>jquery.min.js"></script><!--jquery js-->
  <script src="<?php echo ADMIN_JS ?>bootstrap.min.js"></script><!--jquery js-->
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
  $('#login_form').validate({
          rules: {
            email : { 
                  required :true,
            },
            password : { 
                  required :true,
              },
          },
          messages: {
              email : {
                 required : 'Please enter valid username',
              },
              password : {
                 required : 'Please enter valid password',
              },
          }
      });

  function get_window_height(){
    var wind_height = $(window).height();
    jQuery(".fb_sign_up #content .container").css({"height":wind_height});
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
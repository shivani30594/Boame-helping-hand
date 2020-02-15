<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>BOAME - Just a Helping Hand</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo ADMIN_IMAGES?>BOAME-transparent.png" />
  <meta name="description" content="BOAME - People Helping People. We (Boame) are a peer to peer financial community made up of selfless and responsible persons of the same unique goal of bridging the gap between the rich and the poor. We give good returns on all donations. We provide a state-of-the-art platform for our community to link up with others to Provide and Receive Help from each other. At Boame, you can meet your needs at ease when you receive help from others. Pay for your hospital, utilities and other bills at ease." />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>animate.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>icon.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>font.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>style.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>owl.carousel.css">
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>owl.theme.default.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="<?php echo ADMIN_JS ?>jquery.min.js"></script>
  <script src="<?php echo ADMIN_JS ?>owl.carousel.min.js"></script><!-- owl js-->
  <style>
  a:hover {
    text-decoration: underline;
  }
  /*9-05-2018*/
  .navbar-toggle .icon-bar {background: black;}
  .navbar-collapse.collapse.in{background: #fff;}
 
  /*9-05-2018*/
</style>
</head>
<body>
  <nav class="navbar navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">
          <img src="<?php echo ADMIN_IMAGES?>BOAME-transparent.png" class="img-responsive" alt="header">
      </a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
      <?php $this->load->view('front-end/header.php')?>
      </ul>
    </div>
  </div>
</nav>
<section class="contact_wrap">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
            <div class="page-breadcroumb">
                <p><a href="index.html">Home</a> / How it Works</p>
            </div>
            <div class="head-global">
                <h2>How It Works</h2>
            </div>
        </div>
      </div>
    </div>
  </section>
  <section class="video_wrap">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="heading-content">Boame markets a wide range of products especially digital products. We market eBooks, Videos, Audios and Softwares. To purchase our products, you need to load your BPoints with at least GHS150 or $35 credit. Once this is done, you can purchase or activate your account. Immediately, you will have access to our wide range of products that you can resell at your own price. </div>
        </div>
        <div class="col-md-12">
          <!-- <div class="video_container">
              <video autoplay id="comming_soon_video" onclick="pauseVid()" controls="controls"> 
                <source src="<?php echo ADMIN_VIDEOS ?>videoplayback.mp4" type="video/mp4" >
                Your browser does not support the video tag.
              </video>
          </div> -->
        </div>
      </div>
    </div>
  </section>
  <!-- Footer-start -->
  <?php $this->load->view('front-end/footer.php')?>
  <!-- Footer-end -->
    <script type="text/javascript">
  $(document).ready(function(){
    $(window).scroll(function(){
      if($(this).scrollTop()>0){
          $(".navigation").addClass("stick" , 500);
      }
      else{
        $(".navigation").removeClass("stick" , 500);
      }
    });
  });
</script>
</body>
</html>
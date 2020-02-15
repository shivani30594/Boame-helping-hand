<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>BOAME - Just a Helping Hand</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo ADMIN_IMAGES?>BOAME-transparent.png" />
  <meta name="description" content="BOAME - People Helping People. We (Boame) are a peer to peer financial community made up of selfless and responsible persons of the same unique goal of bridging the gap between the rich and the poor. We give good returns on all donations. We provide a state-of-the-art platform for our community to link up with others to Provide and Receive Help from each other. At Boame, you can meet your needs at ease when you receive help from others. Pay for your hospital, utilities and other bills at ease" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>animate.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>icon.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>font.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>style.css" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="<?php echo ADMIN_JS ?>jquery.min.js"></script>
</head>
<style>
  .error{color:red;}
  a:hover {
    text-decoration: underline;
  }
  /*9-05-2018*/
  .navbar-toggle .icon-bar {background: black;}
  .navbar-collapse.collapse.in{background: #fff;}
  /*9-05-2018*/
</style>
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
    <?php if ($this->session->flashdata('success')): ?>
         <div class="success-msg">
          Your message has been send.
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
         <div class="error-msg">
          Something happens wrong! Please try again later.
        </div>
    <?php endif; ?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
            <div class="page-breadcroumb">
                <p><a href="index.html">Home</a> / Contact us</p>
            </div>
            <div class="head-global">
                <h2>Contact us</h2>
                <p class="page-subtitle">- Get in touch with us </p>
            </div>
        </div>
      </div>
    </div>
  </section>

<section class="map_wrap">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div id="map-canvas"></div>
        <!-- Google Maps API -->
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtrTbZ4p7_0BA0SD6YX6aLS1vbHzbLhis&callback=initialize"
  type="text/javascript"></script>
        <script>
            function initialize() {
              var mapOptions = {
                zoom: 16,
                scrollwheel: false,
                center: new google.maps.LatLng( 5.614223, -0.196336)
              };

              var map = new google.maps.Map(document.getElementById('map-canvas'),
                  mapOptions);

              var marker = new google.maps.Marker({
                position: map.getCenter(),
                icon: 'img/map-marker.png',
                map: map
              });

            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>  
      </div>
    </div>
  </div>
</section>
<section class="contactform">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <form action="<?php echo BASE_URL?>home/add_contact_us" id="contact_us_form" data-validate="parsley" method="post" >
          <div class="contact-form">
              <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12" >
                      <p><input type="text" placeholder="Name" id="name" name="name"></p>
                      <p><input type="email" placeholder="Email" id="email" name="email"></p>
                      <p><input type="text" placeholder="Subject" id="subject" name="subject"></p>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <p><textarea cols="30" rows="10" placeholder="Message" name="message" id="message"></textarea></p>
                  </div>
              </div>
              <p class="text-center"><input type="submit" value="Send Message!"></p>
          </div>
        </form>
          <div class="contact-info">
              <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="contact-info-left">
                          <p>We (Boame) provide digital materials and we are made up of selfless and responsible persons of the same unique goal of bridging the gap between the rich and the poor.<br>

We provide a state-of-the-art platform for our community to link up with others who have access to our wide range of products that empowers our members. At Boame, you can meet your needs at ease when you earn mouth watering commissions from the efforts of your team. Pay for your hospital, utilities and other bills at ease. Contact us today.</p></div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="contact-info-right">
                          <p><i class="fa fa-map-marker"></i> 25th Central Link, Manet Gardens, Off Spintex Road, Batsoona, Accra</p>
                          <p><i class="fa fa-phone-square"></i> +233 50 8646584 ,+233 50 8646379, +233 50 8646357 , +233 50 8646937</p>
                          <p><i class="fa fa-envelope"></i> support@boame.net</p>  
                          <p><i class="fa fa-paper-plane"></i> <a style="color:#666" href="https://t.me/joinchat/AAAAAE-UAkTveWA02PocFQ">Contact us on Telegram</a></p>                                    
                      </div>
                  </div>
              </div>
          </div>
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
<script src="<?php echo ADMIN_JS;?>jquery.validate.js"></script>
<?php $this->load->view('front-end/script');?>
</body>
</html>
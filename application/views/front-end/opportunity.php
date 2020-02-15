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
  <script src="<?php echo ADMIN_JS ?>jquery.min.js"></script>
  <script src="<?php echo ADMIN_JS ?>owl.carousel.min.js"></script><!-- owl js-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
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
    <div class="container">
      <div class="row">
        <div class="col-md-12">
            <div class="page-breadcroumb">
                <p><a href="index.html">Home</a> / Opportunity</p>
            </div>
            <div class="head-global">
                <h2>Opportunity</h2>
            </div>
        </div>
      </div>
    </div>
  </section>
  <section class="video_wrap">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="">Boame offers you the opportunity to earn good money from the efforts of your team. Whenever someone from your team makes a purchase, you are likely to make commissions. Refer to our compensation plan below.  </div>
        </div>
        <div class="col-md-12" style="text-align:justify">
            <hr>
            <div>
                <h4><b>Referral Commission</b></h4>
                <p>You will earn referrals on 5 levels as follows:</p>
                <ul>
                <li>Level 1 – 10%</li>
                <li>Level 2 – 8%</li>
                <li>Level 3 – 5%</li>
                <li>Level 4 – 2%</li>
                <li>Level 5 – 2%</li>
                </ul>
                <p>To explain, whenever you (Mary) refer some body directly (Algore) and Algore makes a purchase of $30, you earn $3 instantly. If Algore refers Yekson and Yekson makes a purchase of $30, Algore earns $3 and Mary earns $2.40 because Yekson is at Mary’s Level 2 and at Algore’s Level 1. So you can earn up to 5 levels deep.</p>
            </div>
            <hr>
            <div>
                <h4><b>Power Bonus</b></h4>
                <p>This is where the real money lies. You earn 15% on your 3rd referral onwards till infinity. Whenever these referrals (from 3rd onwards) refer their first two and they activate their accounts, you earn $4.50 each from them. You will keep earning this on their first twos of their first twos till infinity. This alone can be your life time residual income when you take this business serious.<br>
                Lets do the maths. Lets assume you had 200 first twos deep in your team, then you will be cashing $900 that month which is much possible.  </p>
            </div>
            <hr>
            <div>
                <h4><b>Matching Bonus</b></h4>
                <p>You can earn good money from here too. You earn 100% on the Power Bonus Earnings of your direct referrals. So assuming I referred Kwesi and Kwesi earn $4.50 in Power Bonus, I will earn that $4.50 too. That’s not too bad.</p>
            </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Footer-start -->
  <?php $this->load->view('front-end/footer.php')?>
  <!-- Footer-end -->
<script>
  $(document).ready(function(){
       $('#banner').owlCarousel({
          animateOut: 'fadeOut',
          animateIn: 'fadeIn',
          items:1,
          itemsCustom : false,
          itemsDesktop : [1199,1],
          itemsDesktopSmall : [980,1],
          itemsTablet: [768,1],
          itemsTabletSmall: false,
          itemsMobile : [479,1],
          singleItem : true,
          itemsScaleUp : false,

          //Basic Speeds
          navSpeed:500,
          dotsSpeed:5000,
          
    
          //Autoplay
    
          autoplay:false,
          autoplaySpeed:3000, 
          autoplayTimeout: 3000,
          autoplayHoverPause:true,

    
          // Navigation
          nav : true,
          navText : [
              "<i class='fa fa-angle-left'></i>",
              "<i class='fa fa-angle-right'></i>"
          ],
          rewind : true,
          scrollPerPage : true,

          // CSS Styles
          baseClass : "owl-carousel",
          theme : "owl-theme",

          //Pagination
          pagination : false,
          paginationNumbers: false,
          
          //Lazy load
          lazyFollow : false,
          lazyEffect : "fade",
          
          //Auto height
          autoHeight : false,
          
          //JSON 
          jsonPath : false, 
          jsonSuccess : false,
         

          //Mouse Events
          dragBeforeAnimFinish : true,
          mouseDrag : true,
          touchDrag : true,
          
          //Transitions
          transitionStyle : true,
          
          // Other
          addClassActive : false,
          
          //Callbacks
          beforeUpdate : false,
          afterUpdate : false,
          beforeInit: false, 
          afterInit: false, 
          beforeMove: false, 
          
          afterMove: false,
          afterAction: false,
          startDragging : false,
          afterLazyLoad : false
         
    });

  $(window).scroll(function(){
      if($(this).scrollTop()>0){
          $(".navigation").addClass("stick");
      }
      else{
        $(".navigation").removeClass("stick");
      }
    });
 
});
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>BOAME - CONNECT, LEARN AND EARN</title>
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="<?php echo ADMIN_JS ?>jquery.min.js"></script>
  <script src="<?php echo ADMIN_JS ?>owl.carousel.min.js"></script><!-- owl js-->
  <style>
  /* add css over */
  .test-img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 3px solid #d9b200;
    display: block;
    margin: 0 auto 30px;
  }
  .test-slide {
    text-align: center;
    padding: 25px;
    border: 1px solid #ebebeb;
    margin: 50px 15px 0;
    position: relative;
  } 
  .test-img img {
    border-radius: 50%;
    object-fit: cover;
    height: 100%;
  }
  .test-decription {
    font-size: 14px;
    line-height: 24px;
    text-align: justify;
    color: #666;
    text-align: center;
    height: 120px;
    overflow: hidden;
  }
  .test-name {
    font-size: 18px;
    line-height: 24px;
    text-align: justify;
    color: #333;
    text-align: center;
    font-weight: 600;
    margin-bottom: 3px;
  }
  p.posted-date {
    font-size: 12px;
    line-height: 24px;
    text-align: justify;
    color: #666;
    text-align: center;
  }
  .test-content {
   
    margin: 0 auto;
  }
  #testimonals .owl-nav{display:none;}
  #testimonals .owl-dots{display:block;}
  #testimonals.owl-theme .owl-dots .owl-dot.active span,#testimonals.owl-theme .owl-dots .owl-dot:hover span{background:#d9b200;}
  #testimonals .owl-stage-outer{overflow:visible;}
  .quotes-icon {
    position: absolute;
    left: 0;
    right: 0;
    top: -12px;
  }
  .quotes-icon i {
    color: #d9b200;
    font-size: 25px;
  }
  </style>
</head>
<body class="home">
  <nav class="navbar navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="https://boame.net">
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
<section class="home_slider">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="owl-carousel owl-theme" id="banner">
          <!-- slider1 -->
          <div class="slider1 slide">
            <div class="slider-content">
              <h3>Helping People  <br> Changing lives</h3>
            </div>
            <div class="upcoming_events">
              <div class="col-md-2"></div>
              <div class="col-md-8">
                <div class="events_wrap">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="title">
                        <h3>
                        We mobilize everyday people, and EMPOWER them, rally others and become professionally self employed individuals.
                        </h3>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="stacks">
                        <ul>
                          <li>
                            <div class="targert">
                              <h2>GHS<?php echo isset($total_gh_amount) ? $total_gh_amount : ''?></h2>
                              <!-- <h2>GHS290600</h2> -->
                              <p>Net Withdrawals</p>
                            </div>
                          </li>
                          <li>
                            <div class="gain">
                              <h2><?php echo isset($total_active_users) ? $total_active_users : ''?></h2>
                              <!-- <h2>2238</h2> -->
                              <p>Active Users</p>
                            </div>
                          </li>
                          <li>
                             <div class="donater">
                              <h2>GHS<?php echo isset($total_ph_amount) ? $total_ph_amount : ''?></h2>
                              <!-- <h2>GHS263900</h2> -->
                              <p>Purchases</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                   
                  </div>
                </div>
              </div>
              <div class="col-md-2"></div>
            </div>
          </div>
          <!-- slider1 -->
          <!-- slider1 -->
          <div class="slider2 slide">
            <div class="slider-content">
              <h3>It’s all big when you’re <br> changing the world</h3>
            </div>
            <div class="upcoming_events">
              <div class="col-md-2"></div>
              <div class="col-md-8">
                <div class="events_wrap">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="title">
                        <h3>
                        We mobilize everyday people, and EMPOWER them, rally others and become professionally self employed individuals.
                        </h3>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="stacks">
                        <ul>
                         <li>
                            <div class="targert">
                              <h2>GHS<?php echo isset($total_gh_amount) ? $total_gh_amount : ''?></h2>
                              <!-- <h2>GHS290600</h2> -->
                              <p>Net Withdrawals</p>
                            </div>
                          </li>
                          <li>
                            <div class="gain">
                              <h2><?php echo isset($total_active_users) ? $total_active_users : ''?></h2>
                              <!-- <h2>2238</h2> -->
                              <p>Active Users</p>
                            </div>
                          </li>
                          <li>
                             <div class="donater">
                              <h2>GHS<?php echo isset($total_ph_amount) ? $total_ph_amount : ''?></h2>
                              <!-- <h2>GHS263900</h2> -->
                              <p>Purchases</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                   
                  </div>
                </div>
              </div>
              <div class="col-md-2"></div>
            </div>
          </div>
          <!-- slider1 -->
          </div>
      </div>
    </div>
  </div>
</section>
 <section class="about-us section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="head-global">
                        <h2>WHO WE ARE</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 wow fadeInUp">
                    <div class="about-photo">
                        <div class="left-frame"></div>
                        <div class="right-frame"></div>
                        <img class="img-responsive" src="<?php echo ADMIN_IMAGES?>about.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-7 wow fadeInUp">
                    <div class="about-text" >
                        <h2>BOAME - CONNECT, LEARN AND EARN</h2>
                        <p style="text-align:justify"> Boame Team consists of selfless and motivated individuals who came together to help upgrade the living standards of its members and reduce poverty. We know that the only way we can change this world is to empower our members and teach them how to be self sustained. This we do by offering members educational materials which they can use to upgrade themselves.</p>
                        <p style="text-align:justify"> Our portfolios ranges from eBooks – Health, do it yourself books, motivational books among others. We have eBooks that teaches members how to start their own business from home, how to start home importation business with minimal money, how to start a fiverr business among others.</p>
                        <p style="text-align:justify"> Members also have access to our wide range of softwares that they can use or better still sell to third parties and keep 100% of proceeds from these sales. Members can also sell our audios, videos and eBooks at their own choice.</p>
                    </div>
                    <div class="our-stats">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-2 col-xs-4">
                                <div class="total-events">
                                    <h2><?php echo isset($total_users) ? $total_users : '' ?><span>Users</span></h2>
                                    <!-- <h2>2956<span>Users</span></h2> -->
                                </div>                                
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-10 col-xs-8">
                                <div class="total-donation-stats">
                                    <p><span class="counter"><?php echo isset($gHCount) ? $gHCount : ''?></span> People Cashed out</p>
                                    <p><span class="counter" style="text-align:center"><?php echo isset($pHCount) ? $pHCount : ''?></span> People made purchases </p>
                                    <!-- <p><span class="counter">2906</span> People got help</p>
                                    <p><span class="counter" style="text-align:center">2639</span> People provide help</p> -->
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 <section class="notification-wrap">
  <div class="container">
      <div class="row">
        <div class="col-md-12">
            <div class="recent-news">
              <div class="head-global">
                  <h2>Top 5 notifications</h2>
              </div>
          </div>
          <div class="col-md-8">
              <table class="table">
                  <tbody class="notification" >
                  </tbody>
                </table>
          </div>
        </div>
    </div>
</section> 
    <section class="recent-news-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 wow fadeIn">
                    <div class="recent-news">
                        <div class="head-global">
                            <h2>RECENT NEWS</h2>
                            <a href="<?php echo BASE_URL?>home/view_all">View All<i class="fa fa-angle-double-right"></i></a>
                        </div>
                        <div class="row">
                        <?php if (count($news) > 0):?>
                          <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="featured-news">
                              <div class="featured-news-content">
                                  <img src="<?php echo ADMIN_NEWS.$news[0]->image?>" alt="">
                                  <div class="featured-news-date">
                                      <p><?php echo date('d',strtotime($news[0]->created_at));?> <span><?php echo date('F',strtotime($news[0]->created_at));?></span></p>
                                  </div>
                              </div>
                              <div class="featured-news-title">
                                  <h2><a href="<?php echo BASE_URL.'home/single/'.$news[0]->id?>"><?php echo $news[0]->title;?></a></h2>
                                  <p><?php echo strip_tags($news[0]->description);?></p>
                                  <a href="<?php echo BASE_URL.'home/single/'.$news[0]->id?>" class="readmore">Read More</a>
                              </div>
                            </div>
                          </div>
                        <?php endif;?>
                        <?php if (count($news) >= 2):?>
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="related-news">
                              <div class="row">
                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                      <div class="single-related-news">
                                          <div class="img_wrap"><img src="<?php echo ADMIN_NEWS.$news[1]->image?>" alt=""></div>
                                          <div class="content_wrap">
                                            <h2><a href="<?php echo BASE_URL.'home/single/'.$news[1]->id?>"><?php echo $news[1]->title;?></a></h2>
                                            <p><?php echo strip_tags($news[1]->description);?></p>
                                          </div>
                                      </div>
                                  </div>
                                  <?php if(isset($news[2]) && !empty($news[2])) : ?>
                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                      <div class="single-related-news">
                                          <div class="img_wrap"><img src="<?php echo ADMIN_NEWS.$news[2]->image?>" alt=""></div>
                                          <div class="content_wrap">
                                            <h2><a href="<?php echo BASE_URL.'home/single/'.$news[2]->id?>"><?php echo $news[2]->title;?></a></h2>
                                            <?php echo $news[2]->description;?>
                                          </div>
                                      </div>
                                  </div>
                                <?php endif;?>
                                </div>
                            </div>
                          </div>
                        <?php endif;?>
                        </div>
                        <?php if (count($news) >= 4):?>
                        <div class="related-news">
                            <div class="row">
                              <?php if(isset($news[3]) && !empty($news[3])) : ?>
                                <div class="col-md-6 col-sm-12 col-xs-12" >
                                    <div class="single-related-news">
                                        <div class="img_wrap"><img src="<?php echo ADMIN_NEWS. $news[3]->image?>" alt=""></div>
                                        <div class="content_wrap">
                                          <h2><a href="<?php echo BASE_URL.'home/single/'.$news[3]->id?>"><?php echo $news[3]->title;?></a></h2>
                                          <p><?php echo $news[3]->description;?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;?>
                            <?php if(isset($news[4]) && !empty($news[4])) : ?>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="single-related-news">
                                        <div class="img_wrap"><img src="<?php echo ADMIN_NEWS.$news[4]->image?>" alt=""></div>
                                         <div class="content_wrap">
                                          <h2><a href="<?php echo BASE_URL.'home/single/'.$news[4]->id?>"><?php echo $news[4]->title;?></a></h2>
                                          <p><?php echo $news[4]->description;?></p>
                                        </div>
                                    </div>
                                </div>
                              <?php endif;?>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php $count=1;?>
   <?php if( isset($top_twenty_users) && count($top_twenty_users) > 0 ):?>
  <section class="top-user-wrap">
    <div class="container">
      <div class="row">
        <div class="head-global">
            <h2>Top 20 Referrers</h2>
        </div>
        <div class="col-xs-12">
          <div class="table-responsive">
            <table>
              <thead>
                <tr>
                  <th>Position</th>
                  <th>Name</th>
                  <th>Referral Code</th>
                  <th>Referral Count</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($top_twenty_users as $value) { ?>
                  <tr>
                  <td><?php echo $count?></td>
                  <td><?php echo $value['first_name'] .' '. $value['last_name']?></td>
                  <td><?php echo $value['refferal_code']?></td>
                  <td><?php echo $value['refferal_count']?></td>
                </tr>
                <?php $count = $count+1;?>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

<!-- testimonials -->
<section class="testimonials-wrap">
  <div class="container">
    <div class="row">
    <div class="col-md-12">
        <div class="head-global">
            <h2>Testimonials</h2>
        </div>
    </div>
      <div class="col-md-12">
        <div class="owl-carousel owl-theme" id="testimonals">
        <?php if (count($testimonials) > 0): ?>
                <?php foreach($testimonials as $testimonial) :?>
                <div class="test-slide">
                    <div class="quotes-icon">
                        <i class="fa fa-quote-left"></i>
                    </div>
                    <div class="test-img">
                        <img src="<?php echo ADMIN_TESTIMONIALS.$testimonial['image']?>" alt="test-img">
                    </div>
                    <div class="test-content">
                        <p class="test-decription"><?php echo $testimonial['message']?> </p>
                        <h3 class="test-name"><?php echo $testimonial['full_name']?></h3>
                        <p class="posted-date"><?php echo $testimonial['created']?><p>
                    </div>
                  </div> 
                <?php endforeach;?>
        <?php endif;?>
          <!-- <div class="test-slide">
            <div class="quotes-icon"><i class="fa fa-quote-left"></i></div>
            <div class="test-img">
              <img src="https://www.boame.net//assets/news/news_1522231259_OEVLWQ0.jpg" alt="test-img">
            </div>
            <div class="test-content">
              <p class="test-decription">Lorem ipsum dolor sit amet constur adipisicing elit sed do eiusmtempor incid etur adipisicing elit sed do eiusmtempor incid etur adipisicing elit sed do eiusmtempor incid et dolore magna </p>
              <h3 class="test-name">Maria Cooper</h3>
              <p class="posted-date">22-Feb-2018<p>
            </div>
          </div> -->

           <!-- <div class="test-slide">
           <div class="quotes-icon"><i class="fa fa-quote-left"></i></div>
            <div class="test-img">
              <img src="https://www.boame.net//assets/news/news_1522231259_OEVLWQ0.jpg" alt="test-img">
            </div>
            <div class="test-content">
              <p class="test-decription">Lorem ipsum dolor sit amet constur adipisicing elit sed do eiusmtempor incid et dolore magna t constur adipisicing elit sed do eiusmtempor incid et dolore magna t constur adipisicing elit sed do eiusmtempor incid et dolore magna </p>
              <h3 class="test-name">Maria Cooper</h3>
              <p class="posted-date">22-Feb-2018<p>
            </div>
          </div> -->

           <!-- <div class="test-slide">
           <div class="quotes-icon"><i class="fa fa-quote-left"></i></div>
            <div class="test-img">
              <img src="https://www.boame.net//assets/news/news_1522231259_OEVLWQ0.jpg" alt="test-img">
            </div>
            <div class="test-content">
              <p class="test-decription">Lorem ipsum dolor sit amet constur adipisicing elit sed do eiusmtempor incid et dolore magnt constur adipisicing elit sed do eiusmtempor incid et dolore magna t constur adipisicing elit sed do eiusmtempor incid et dolore magna a </p>
              <h3 class="test-name">Maria Cooper</h3>
              <p class="posted-date">22-Feb-2018<p>
            </div>
          </div> -->

           <!-- <div class="test-slide">
           <div class="quotes-icon"><i class="fa fa-quote-left"></i></div>
            <div class="test-img">
              <img src="https://www.boame.net//assets/news/news_1522231259_OEVLWQ0.jpg" alt="test-img">
            </div>
            <div class="test-content">
              <p class="test-decription">Lorem ipsum dolor sit amet constur adipisicing elit sed do eiusmtempor incid ett constur adipisicing elit sed do eiusmtempor incid et dolore magna t constur adipisicing elit sed do eiusmtempor incid et dolore magna  dolore magna </p>
              <h3 class="test-name">Maria Cooper</h3>
              <p class="posted-date">22-Feb-2018<p>
            </div>
          </div> -->

            <!-- <div class="test-slide">
              <div class="quotes-icon"><i class="fa fa-quote-left"></i></div>
                  <div class="test-img">
                    <img src="https://www.boame.net//assets/news/news_1522231259_OEVLWQ0.jpg" alt="test-img">
                  </div>
                  <div class="test-content">
                    <p class="test-decription">Lorem ipsum dolor sit amet constur adipisicing elit sed do eiusmtempor incid ett constur adipisicing elit sed do eiusmtempor incid et dolore magna t constur adipisicing elit sed do eiusmtempor incid et dolore magna  dolore magna </p>
                    <h3 class="test-name">Maria Cooper</h3>
                    <p class="posted-date">22-Feb-2018<p>
                  </div>
              </div>
          </div> -->
      </div>      
  </div>
</section>
<!-- testimonials -->

<?php endif;?>
 <!-- Footer-start -->
  <?php $this->load->view('front-end/footer.php')?>
  <!-- Footer-end -->
<script>
  $(document).ready(function(){
    update();
       $('#banner').owlCarousel({
          loop:true,
          margin:0,
          responsiveClass:true,
          responsive:{
              0:{
                  items:1,
                  nav:true
              },
              600:{
                  items:1,
                  nav:false
              },
              1000:{
                  items:1,
                  nav:true,
                  loop:false
              }
          }
         
    });

    $('#testimonals').owlCarousel({
          loop:true,
          margin:0,
          responsiveClass:true,
          responsive:{
              0:{
                  items:1,
                  nav:true
              },
              600:{
                  items:1,
                  nav:false
              },
              1000:{
                  items:2,
                  nav:true,
                  loop:false
              }
          }
    });
  $(window).scroll(function(){
      if($(this).scrollTop()>0){
          $(".navigation").addClass("stick");
      }
      else{
        $(".navigation").removeClass("stick");
      }
    });
 function update() {
  $(".notification").html('Loading..'); 
    $.ajax({
        type: 'GET',
        url: '<?php echo BASE_URL?>home/notifications',
        timeout: 2000,
        success: function(data) {
          var data = jQuery.parseJSON(data);
          var html = '';
          for (var i = 0; i < data.length; i++) {
            html += "<tr><td class='noti-content'>"+(i+1)+"</td><td class='noti-content'>"+data[i].admin_notification+"</td></tr>";
          };
          $(".notification").html(html);
         // window.setTimeout(update, 10000);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          $(".notification").html('Timeout contacting server..');
          //window.setTimeout(update, 60000);
        }
    });
  }
});
</script>
</body>
</html>
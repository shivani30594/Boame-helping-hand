<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title><?php echo $meta_title; ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo ADMIN_IMAGES?>BOAME-transparent.png" />
  <meta name="description" content="Boame - People Helping People
We (Boame) are a peer to peer financial community made up of selfless and responsible persons of the same unique goal of bridging the gap between the rich and the poor.

We give good returns on all donations. We provide a state-of-the-art platform for our community to link up with others to Provide and Receive Help from each other. At Boame, you can meet your needs at ease when you receive help from others. Pay for your hospital, utilities and other bills at ease." />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>animate.css" type="text/css" />
  <!-- <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>front_css.css" type="text/css" /> -->
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>icon.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>font.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>app.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ADMIN_JS;?>datatables/datatables.css" type="text/css"/> 
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>intlTelInput.css" type="text/css"/>  
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>sprite.scss" type="text/scss"/>  
  <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>  

  <link href="<?php echo ADMIN_CSS;?>sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
   <style type="text/css">
    .nav-tabs > li.active > a {
       border-color: #285e8e !important;
       border-bottom-color: #285e8e !important;
      }
      .fa-5x
      {
        font-size:8em;
      }
    /*  body {
          font-family: sans-serif;
          font-size: 15px;
        }*/
        div.dataTables_length {
        float: left;
    }

    div.dataTables_filter {
        float: right;
    }

    div.dataTables_info {
        float: left;
    }

    div.dataTables_paginate {
        float: right;
    }

    div.DTTT {
        float: left;
        margin-right: 50px;
    }

    div.buttons {
        clear: both;
    }
    .tree ul {
      position: relative;
      padding: 1em 0;
      white-space: nowrap;
      margin: 0 auto;
      text-align: center;
    }
    .tree ul::after {
      content: '';
      display: table;
      clear: both;
    }
    .tree li {
      display: inline-block;
      vertical-align: top;
      text-align: center;
      list-style-type: none;
      position: relative;
      padding: 1em 0.5em 0 0.5em;
    }
    .tree li::before, .tree li::after {
      content: '';
      position: absolute;
      top: 0;
      right: 50%;
      border-top: 1px solid #ccc;
      width: 50%;
      height: 1em;
    }
    .tree li::after {
      right: auto;
      left: 50%;
      border-left: 1px solid #ccc;
    }
    .tree li:only-child::after, .tree li:only-child::before {
      display: none;
    }
    .tree li:only-child {
      padding-top: 0;
    }
    .tree li:first-child::before, .tree li:last-child::after {
      border: 0 none;
    }
    .tree li:last-child::before {
      border-right: 1px solid #ccc;
      border-radius: 0 5px 0 0;
    }
    .tree li:first-child::after {
      border-radius: 5px 0 0 0;
    }
    .tree ul ul::before {
      content: '';
      position: absolute;
      top: 0;
      left: 50%;
      border-left: 1px solid #ccc;
      width: 0;
      height: 1em;
    }
    .tree li a {
      border: 1px solid #ccc;
      padding: 0.5em 0.75em;
      text-decoration: none;
      display: inline-block;
      border-radius: 5px;
      color: #333;
      position: relative;
      top: 1px;
    }
    .tree li a:hover, .tree li a:hover + ul li a {
      background: #1aae88;
      color: #fff;
      border: 1px solid #1aae88;
    }
    .tree li a:hover + ul li::after, .tree li a:hover + ul li::before, .tree li a:hover + ul::before, .tree li a:hover + ul ul::before {
      border-color: #1aae88;
    }

    .tree ul li{
      font-size:15px;
    }
    .error {
    color: red;
  }
 /*9-07-2018*/
 .scrollable.wrapper .panel-resource {
  border: 0;
  background-color: transparent;
  border-radius: 0;
}
.scrollable.wrapper .panel-resource .panel-heading{
  background-color: transparent !important;
  border-color: transparent !important;
  border:0 !important;
}
.scrollable.wrapper .panel-resource ul{
  overflow: visible;
  background: #F5F7FA;
  height: 25px;
  margin: 21px 0 14px;
  padding-left: 14px;
  position: relative;
  z-index: 1;
  width: 100%;
  border-bottom: 1px solid #E6E9ED;
}
.scrollable.wrapper .panel-resource ul li{
  border: 1px solid #E6E9ED;
  color: #333!important;
  margin-top: -17px;
  margin-left: 8px;
  background: #fff;
  border-bottom: none;
  border-radius: 4px 4px 0 0;
  width: auto !important;
}
.scrollable.wrapper .panel-resource ul li a{
  padding: 10px 17px;
  background: #F5F7FA;
  margin: 0;
  border-top-right-radius: 0;
  line-height: 1.42857143;
  border: 1px solid transparent;
  border-radius: 4px 4px 0 0;
}
.scrollable.wrapper .panel-resource ul li.active{
   border-right: 6px solid #D3D6DA;
    border-top: 0;
    margin-top: -15px;
}
.scrollable.wrapper .panel-resource ul li.active a{
  border-bottom: none;
  border-color: #E6E9ED !important;
}
#link h5{
  font-size: 16px;
  font-weight: 700;
  color: #73879C;
  font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
}
#link .btn-info {
  padding: 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    background-color: #337ab7;
    border-color: #2e6da4;
    margin-top: 0;
}
#referral_link{
  color: #F39C12;
  font-weight: 700;
  font-size: 17px;
  font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
  padding-left:15px;
  -webkit-box-ordinal-group:3;
    -ms-flex-order:2;
        order:2;
}
#link .clear{
  display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
    -webkit-box-pack: start;
        -ms-flex-pack: start;
            justify-content: flex-start;
}
#banner .col-md-3 img{width:100%;}
#banner .col-md-3 .form-group{
  text-align:center;
  margin-top:10px;
}
#banner .col-md-3 .form-group a{
  background: #26B99A;
    border: 1px solid #169F85;
}
#pdf .col-md-3{text-align:center;}
#pdf .col-md-3 > a,#ppt .col-md-3 > a {color: #5A738E; font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.471;
}
@media screen and (max-width:991px){
  .scrollable.wrapper > .col-md-12{padding:0;}
  .scrollable.wrapper .panel-resource .panel-heading{padding-left:0; padding-right:0;}
  .scrollable.wrapper .panel-resource ul{padding-left:0;}
  .scrollable.wrapper .panel-resource ul li{margin-left:5px;}
  #pdf .col-md-3,#ppt .col-md-3{width: 25%; float:left;}
  #banner .col-md-3{width:50%; float:left;}
}
@media screen and (max-width:767px){
  #pdf .col-md-3,#ppt .col-md-3{width: 33.33333333%;}
}
@media screen and (max-width:520px){
  .scrollable.wrapper .panel-resource ul li{
    margin-top: 10px !important;
    border: 1px solid #E6E9ED;
    border-radius: 0;
  }
  .scrollable.wrapper .panel-resource ul{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -ms-flex-wrap:wrap;
    flex-wrap:wrap;
    border-bottom:0;     
    margin-top: 0;
    height: 100%;
  }
  .scrollable.wrapper .panel-resource ul li.active{
    border-right:1px solid #E6E9ED;
    border-top: 3px solid #D3D6DA;
  }
  #link .clear{
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
  }
  #referral_link{
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        padding-left:0;
        margin-top:5px;
  }
}
@media screen and (max-width:480px){
  #pdf .col-md-3,#ppt .col-md-3{
    width: 50%;
    margin-bottom: 20px;
  }
  #banner .col-md-3{width:100%;}
  #video video{width:100% !important;}
}
  /*9-07-2018*/
  </style>
</head>
<body class="">
   <div id="alerts">
    <noscript>
      <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4><i class="fa fa-bell-alt"></i>Warning!</h4>
        <p>Oops! Javascript to be disabled in your browser. You must have Javascript enabled in your browser to utilize the functionality of the website.</p>
      </div>
    </noscript>
  </div>
  <section class="vbox">
    <header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
      <div class="navbar-header aside-md dk">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
          <i class="fa fa-bars"></i>
        </a>
        <a href="<?php echo BASE_URL?>" class="navbar-brand">
          <img src="<?php echo ADMIN_IMAGES?>BOAME-transparent.png" class="m-r-sm" alt="scale">
          <span class="hidden-nav-xs">BOAME</span>
        </a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
          <i class="fa fa-cog"></i>
        </a>
      </div>
     <!--  <ul class="nav navbar-nav hidden-xs">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="i i-grid"></i>
          </a>
          <section class="dropdown-menu aside-lg bg-white on animated fadeInLeft">
            <div class="row m-l-none m-r-none m-t m-b text-center">
              <div class="col-xs-4">
                <div class="padder-v">
                  <a href="#">
                    <span class="m-b-xs block">
                      <i class="i i-mail i-2x text-primary-lt"></i>
                    </span>
                    <small class="text-muted">Mailbox</small>
                  </a>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="padder-v">
                  <a href="#">
                    <span class="m-b-xs block">
                      <i class="i i-calendar i-2x text-danger-lt"></i>
                    </span>
                    <small class="text-muted">Calendar</small>
                  </a>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="padder-v">
                  <a href="#">
                    <span class="m-b-xs block">
                      <i class="i i-map i-2x text-success-lt"></i>
                    </span>
                    <small class="text-muted">Map</small>
                  </a>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="padder-v">
                  <a href="#">
                    <span class="m-b-xs block">
                      <i class="i i-paperplane i-2x text-info-lt"></i>
                    </span>
                    <small class="text-muted">Trainning</small>
                  </a>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="padder-v">
                  <a href="#">
                    <span class="m-b-xs block">
                      <i class="i i-images i-2x text-muted"></i>
                    </span>
                    <small class="text-muted">Photos</small>
                  </a>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="padder-v">
                  <a href="#">
                    <span class="m-b-xs block">
                      <i class="i i-clock i-2x text-warning-lter"></i>
                    </span>
                    <small class="text-muted">Timeline</small>
                  </a>
                </div>
              </div>
            </div>
          </section>
        </li>
      </ul> -->
   <!--    <form class="navbar-form navbar-left input-s-lg m-t m-l-n-xs hidden-xs" role="search">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-sm bg-white b-white btn-icon"><i class="fa fa-search"></i></button>
            </span>
            <input type="text" class="form-control input-sm no-border" placeholder="Search apps, projects...">            
          </div>
        </div>
      </form> -->
      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="thumb-sm avatar pull-left">
            <img src="<?php echo (isset($member_details) AND $member_details->picture != '') ? $member_details->picture : ADMIN_IMAGES.'default-icon.png' ?>" class="img-circle" alt="">
            </span>
             <?php echo $member_details->first_name . ' ' . $member_details->last_name ?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight">            
            <li>
              <a href="<?php echo BASE_URL .'profile'?>">Profile</a>
            </li>
            <li>
              <a href="<?php echo BASE_URL .'referral'?>">Referral Link</a>
            </li>
          <!--   <li>
            <a href="<?php echo BASE_URL .'withdraw'?>">Withdraw e-wallet</a>
          </li> -->
            <li class="divider"></li>
            <li>
              <a href="<?php echo isset($logout_url) ? $logout_url : BASE_URL.'user/logout'?>" >Logout</a>
            </li>
          </ul>
        </li>
      </ul>      
    </header>
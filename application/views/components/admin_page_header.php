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
  
  <style type="text/css">
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
      color:red;
    }
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
           <img src="<?php echo ADMIN_PROFILE.$admin_details->image ?>" alt="..."> 
            </span>
            <?php echo $admin_details->first_name . ' ' . $admin_details->last_name ?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight">            
            <li>
              <a href="<?php echo BASE_URL. 'admin/security/logout'?>" >Logout</a>
            </li>
          </ul>
        </li>
      </ul>      
    </header>
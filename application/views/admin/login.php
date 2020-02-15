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
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>icon.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>font.css" type="text/css" />
  <link rel="stylesheet" href="<?= ADMIN_CSS; ?>app.css" type="text/css" />
  <style>
  .m-b-lg {
    text-align: center;
  }
  .btn-block + .btn-block {
    margin-top: 5px;
  }
  .btn-facebook {
      color: #fff;
      background-color: #3b5998;
      border-color: rgba(0,0,0,0.2);
  }
  .btn-social {
      position: relative;
      padding-left: 44px;
      text-align: left;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
  }
  .btn-block {
      display: block;
      width: 100%;
  }
  .btn {
      display: inline-block;
      padding: 6px 12px;
      margin-bottom: 0;
      font-size: 14px;
      font-weight: normal;
      line-height: 1.42857143;
      text-align: center;
      white-space: nowrap;
      vertical-align: middle;
      -ms-touch-action: manipulation;
      touch-action: manipulation;
      cursor: pointer;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      background-image: none;
      border: 1px solid transparent;
      border-radius: 4px;
  }
  .fa {
      display: inline-block;
      font: normal normal normal 14px/1 FontAwesome;
      font-size: inherit;
      text-rendering: auto;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
  }
  </style>
</head>
<body class="">
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
      <section class="m-b-lg">
        <form action="<?php echo BASE_URL?>admin/security/login" method="post">
        <img src="<?php echo ADMIN_IMAGES ;?>BOAME-transparent.png" alt="" height="200px" width="200px">    
        <!--   <h1><?php echo $referal_code?></h1> -->
        <h3>Admin</h3>
          <div class="list-group">
            <div class="list-group-item">
              <input type="email" placeholder="Email" class="form-control no-border" name="email">
            </div>
            <div class="list-group-item">
               <input type="password" placeholder="Password" class="form-control no-border" name="password">
            </div>
          </div>
          <button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
        </form>
      </section>
    </div>
  </section>
  <!-- footer -->
  <footer id="footer">
    <div class="text-center padder">
      <p>
        <small>BOAME Web Application<br>&copy; 2018</small>
      </p>
    </div>
  </footer>
  <!-- / footer -->
  <script src="<?php echo ADMIN_JS ;?>jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="<?php echo ADMIN_JS ;?>bootstrap.js"></script>
  <!-- App -->
  <script src="<?php echo ADMIN_JS ;?>app.js"></script>  
  <script src="<?php echo ADMIN_JS ;?>slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo ADMIN_JS ;?>app.plugin.js"></script>
</body>
</html>
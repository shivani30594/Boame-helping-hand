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
  <link rel="stylesheet" href="https://www.boame.net//assets/css/style.css" type="text/css" />
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

#register_form{
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
    #register_form{
        -ms-flex-wrap:wrap;
    flex-wrap:wrap;
    }
}
@media screen and (max-width:340px){
    .fb_sign_wrap{padding:15px; display:block; margin:15px auto;}
}
/* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.3);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
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
        <form method="post" action="<?php echo BASE_URL?>user/register" name="register_form" id="register_form">
        <div class="left-form">
          <img src="<?php echo ADMIN_IMAGES ;?>BOAME-transparent.png" alt="" height="200px" width="200px">  
          <h3> Welcome to BOAME </h3>   
          <h5> BE EMPOWERED, BE RICH</h5>
          <a href="<?php echo $login_url?>" class="btn btn-lg btn-primary fb_btn"><i class="fa fa-fw fa-facebook"></i> Continue With Facebook</a>
        </div>
        <div class="right-form">
        <ul class="list" style="color:red">
            <li id = "referral_error" style="display:none"><span >Referral code is not exists.</span></li>
            <li id = "email_error" style="display:none"><span>EmailID already exists in our list.</span></li>
            <li id = "phone_number_error" style="display:none" ><span >Sorry, Couldn't verify your phone number.</span></li>
            <li id = "verification_code_error" style="display:none"><span >Sorry, Please enter valid verification code.</span></li>
            <li id = "verifyed_success" style="display:none"><span >Yeah, Phone number verified successfully!</span></li>
        </ul>
          <div class="list-group">
            <div class="list-group-item">
              <input type="text" placeholder="First Name" name="first_name" id="first_name" class="form-control no-border">
            </div>
            <div class="list-group-item">
              <input type="text" placeholder="Last Name" name="last_name" id="last_name" class="form-control no-border">
            </div>
            <div class="list-group-item">
              <input type="email" placeholder="Email" name="username" id="username" class="form-control no-border">
            </div>
            <div class="list-group-item">
               <input type="password" placeholder="Password" class="form-control no-border" name="password" id="password">
            </div>
            <div class="list-group-item">
               <input type="password" placeholder="Confirm Password" class="form-control no-border" name="confirm_password" id="confirm_password">
            </div>
            <div class="list-group-item">
                <input type="text" placeholder="Referral Code" name="referral_Code" id="referral_Code" value="<?php echo (isset($referal_code) && $referal_code != "" ? $referal_code : "");?>" class="form-control no-border" >
            </div>
            <div class="list-group-item">
                <input type="tel" placeholder="" class="form-control no-border" name="phone_number" id="phone_number">
            </div>
            <div class="list-group-item" id="verify_code" style="display:none">
              <input type="text" placeholder="Verification Code" name="verification_code" id="verification_code" class="form-control no-border" required>
            </div>
          </div>
          <div class="checkbox m-b">
            <label>
              <input type="checkbox" name="agree" id="agree">I agree with BOAME's<a data-toggle="modal" data-target="#terms"> Terms Of Use</a>
            </label>
          </div>
          <button type="submit" class="btn btn-lg btn-primary btn-block">Sign up</button>
          <div class="line line-dashed"></div>
          <p class="text-muted text-center"><small>Already have an account?</small> <a href="<?php echo BASE_URL?>user/signin" class="">Sign in</a></p>
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
  <div class="loading" style="display:none">
  &#8230;</div>
  <!-- terms and considtions  -->
  <div class="col-md-12 ">
    <div class="modal fade" id="terms" role="dialog">
      <div class="modal-dialog  modal-lg">
      <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">TERMS OF SERVICE</h4>
            </div>
            <div class="modal-body">
                <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">BOAME</font></font></font><font color="#474747"><font face="inherit, serif"><font size="6">&nbsp;</font></font></font><font color="#474747"><font face="Arial Narrow, serif"><font size="4">TERMS OF SERVICE</font></font></font></p>

                <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Effective Date: March 20, 2018</font></font></font></p>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">PLEASE CAREFULLY READ THESE TERMS OF SERVICE. THESE TERMS OF SERVICE MAY HAVE CHANGED SINCE YOUR LAST VISIT TO THIS WEBSITE OR ANY OTHER AFFILIATED WEBSITE. BY USING THIS APPLICATION OR ANY OTHER AFFILIATED APPLICATION, YOU INDICATE YOUR ACCEPTANCE OF THESE TERMS OF SERVICE. IF YOU DO NOT ACCEPT THESE TERMS OF SERVICE, THEN DO NOT USE THIS WEBSITE OR ANY OTHER AFFILIATED WEBSITE.</font></font></font></p>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">You must acknowledge and agree to the following Terms of Service to participate in any services offered and/or provided by Boame:</font></font></font></p>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">GENERAL TERMS:</font></font></font></p>

                <ol>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">You agree to be at least 18 years of age and/or of legal age.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">You acknowledge that you are acting as an individual and not on behalf of any other entity, government agency and/or any authority.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">You acknowledge that you are not an employee of or affiliated with any government agency. Our offer(s) are void where prohibited by law.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">The services of Boame</font></font></font><font color="#474747"><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font></font><font color="#474747"><font face="Arial Narrow, serif"><font size="4">are available only to qualified members and individuals personally invited by them.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Every transaction made between Boame</font></font></font><font color="#474747"><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font></font><font color="#474747"><font face="Arial Narrow, serif"><font size="4">and its members are considered to be private and confidential in nature.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">All members&rsquo; personal information, financial reports, account balances, messages and other info displayed and/or stored by Boame are private in nature and will not be disclosed to third parties. We will never give, sell or disclose information to any third parties.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Boame sells and markets digital products like eBooks, Softwares and audios.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">You can purchase any of our products and earn commissions anytime you refer someone to purchase from your Back offices.&nbsp;</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">After creating account, you must activate your account within 72 hours or else, your account will be closed without notice.&nbsp;</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Always contact our support staff through our designated lines to address your issues.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">We can admit a certain number of people per day, this will enable our system from being jammed.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Our site and app might go under maintenance at any time. Whenever this happens, please have patience till we fix it.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">For referral bonuses, 100% is withdrawable and your eWallet will be credited with commissions anytime someone joins and pays with your link. This will be effective from the day we launch.&nbsp;</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Our system verifies all accounts. Make sure you use the right phone numbers.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">We don&#39;t have chat rooms. All issues must be directed to support.</font></font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">COMPANY DISCLAIMER:</font></font></font></p>

                <ol>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Boame is a pending incorporation as a Limited Liability Company.</font></font></font></p>
                    </li>
                </ol>

                <ol start="2">
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Boame</font></font></font><font color="#474747"><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font></font><font color="#474747"><font face="Arial Narrow, serif"><font size="4">is not a bank, deposit taking company, a financial institution nor a security firm. We just create a platform to sell our products and services to our members.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">We do not promise interest on funds you may use to purchase.</font></font></font></p>
                    </li>
                </ol>

                <ol start="4">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">All the materials and information of this Website, as well as any other content, are available and rendered &quot;as is&quot;, without any kind of express or implied guaranties, such as the implied warranties of fitness for a particular purpose, merchantability, or non-infringement.</font></font></p>
                    </li>
                </ol>

                <ol start="5">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Boame</font></font><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">does not provide any legal, insurance, tax or investment advice. No information contained within this website should be considered as our recommendation or a recommendation of other parties, to obtain or dispose of any security or investment or to involve itself in any investment transaction or method. Under no circumstances shall Boame</font></font><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">bear responsibility for any kind of loss, decline or damages as a result of that should arise out of or in relation with the performance at this Website, its content or inability to use it unless otherwise provided by law.</font></font></p>
                    </li>
                </ol>

                <ol start="6">
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Boame</font></font></font><font color="#474747"><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font></font><font color="#474747"><font face="Arial Narrow, serif"><font size="4">does not confirm that the data presented as the content as decisive, complete, correct, or affirmed.</font></font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">MONEY LAUNDERING /ANTI-TERRORISM:</font></font></font></p>

                <ol>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">You are under local and international money laundering prevention law and related anti-terrorism laws, therefore; it is illegal to conduct or attempt to conduct a financial transaction with proceeds known to be from any specified unlawful activity. Such an activity may include the intent to promote, the carrying out of unlawful activity, the evasion of taxes, and/or to conceal or disguise the nature of the proceeds and reporting requirements.</font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">MEMBERSHIP</font></font></font></p>

                <ol>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">New member registration at Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">requires a registration and account activation. Registrations are free from your sponsor/referrer. If you do not have a sponsor/referrer, you may contact us to assign you to a referrer.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">To participate in any services or offerings by Boame,</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">members are required to abide by the rules and regulations of Boame.</font></font></p>
                    </li>
                </ol>

                <ol start="3">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">You acknowledge that Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">may and/or will temporarily close open enrollment for periods of time at our discretion. You may continue to promote Boame during this period and when enrollment reopens; your direct referral may join the Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">membership at that time.</font></font></p>
                    </li>
                </ol>

                <ol start="4">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Boame allows the creation of one account per member. Your account will be identified from the IP address that you register from. A discovery of more than one account from your IP address will be deemed as a violation of these Terms of Service (TOS). Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">may suspend your account temporarily or block it permanently. You may create an additional account but it must be from another IP address.</font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">PURCHASING RULES:</font></font></font></p>

                <ol>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Every transaction between Boame</font></font><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">and its Members is considered to be private in nature.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Members shall execute all financial transactions solely at their own discretion and risk. The member will determine the size and term of purchase based upon their own predetermined risk tolerance.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Compensations and all other commissions are calculated, accrued and credited to the member&#39;s account depending on the member&rsquo;s choice of referrals based upon the stated terms of the plans.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">You accept sole responsibility for any and all state and local taxes as charged, and hereby indemnify Boame and its owners and agents of such liability.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Boame is not responsible and/or liable for any internal or external loss of funds due to password sharing and/or identity theft.</font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">USE OF BOAME AFFILIATE PROGRAM:</font></font></font></p>

                <ol>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">offers&nbsp;an affiliate program along with other methods to generate income. All&nbsp;Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">members have the right to participate in the affiliate program. The requirements for members to use this program are: have current membership status and an active account in any service offered by Boame.</font></font></p>
                    </li>
                </ol>

                <ol start="2">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Boame members&nbsp;are not permitted to send SPAM or any kind of unsolicited commercial e-mail to promote or market&nbsp;Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">offerings and/or services. SPAM senders&rsquo; accounts will be removed by&nbsp;Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">whenever facts of SPAM become known and proven.</font></font></p>
                    </li>
                </ol>

                <ol start="3">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Boame&nbsp;offers its membership a 10% - 8% - 5% - 2% - 2% multilevel referral commissions. Commissions are earned from every BPoint purchase of your direct referrals: a referral is a member that you have sponsored via your personalized referral link.</font></font></p>
                    </li>
                </ol>

                <ol start="4">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">As an affiliate, will earn 10% of the BPoints purchases of members that have registered via your personalized referral link. You will earn 8% of the deposits made by your second-line referrals (the members that have in registered by your first-line referrals) and you will receive 5% of the deposits of your third-line referrals (the members that have been registered by your second-line referrals), 2% of the deposits of your forth-line referrals (the members that have been registered by your third-line referrals) and 2% of the deposits of your fifth -line referrals (the members that have been registered by your forth-line referrals)</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">For Power Bonus, Boame gives 15% on the purchases of your 3</font></font><sup><font face="Arial Narrow, serif"><font size="4">rd</font></font></sup><font face="Arial Narrow, serif"><font size="4"> referral, his first and the first twos of their first twos till infinity.</font></font></p>
                    </li>
                    <li>
                    <p><a name="_GoBack"></a> <font face="Arial Narrow, serif"><font size="4">In regards to Matching Bonus, one receives 100% of the earnings of their direct referrals Power Bonus earnings. For instance if Faith refers Kuma, and Kuma makes GHS45 as referral commission, Faith also earns GHS45.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">As part of the&nbsp;Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">vision&nbsp;is to create a community atmosphere in regards to sponsorships. Affiliates are required to assist and the responsible to their direct referrals in learning the operations of Boame. Boame will assist its affiliates with accurate information and materials within the company website to achieve this.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Boame is a pending trademarked company. Affiliates (members) are prohibited to form any public groups, forums, chat rooms etc. with the Boame name, use the initials BPoints, our logo, associated trademarks or any other methods that would imply that you are a representative of Boame without the express permission and consent from us. Any violation of this rule may result in account suspension and/or legal action.</font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">COMMISSIONS, RATES AND CONTENT</font></font></font></p>

                <ol>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Boame reserve the right to change and/or amend the commissions, rates, Terms of Service (TOS) at any given time and at our sole discretion, with respect to the integrity and security of our members interests. You agree it is your responsibility to review the most updated version of our Terms of Service listed here to which you are bound. Certain provisions of our Terms of Service may be superseded by other legal notices located in other parts of our website.</font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">COPYRIGHT INFRINGEMENT</font></font></font></p>

                <ol>
                    <li>
                    <p><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">Boame</font></font></font><font color="#474747"><font face="Arial, serif"><font size="2">&nbsp;</font></font></font><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">retains all rights to any all materials which includes text, images, PDF, eBooks, video, logos, on the Boame</font></font></font><font color="#474747"><font face="Arial, serif"><font size="2">&nbsp;</font></font></font><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">website. The unauthorized reproduction of any website text, images, PDF and video material is strictly prohibited and any unauthorized reproduction by any person or persons may be subject to legal and copyright infringement proceedings.</font></font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">COMMUNICATIONS</font></font></font></p>

                <ol>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">You agree that all discussed information and/or replies coming from Boame</font></font><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">by any means of communication which include electronic mail and direct mail are of a private nature, therefore; any disclosure from us must be kept confidential and is protected by copyright.</font></font></p>
                    </li>
                </ol>

                <ol start="2">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">If you are not an active member, you are prohibited from modifying, copying, distributing, transmitting, publishing, selling, creating derivative works and/or using any information available on and/or through Boame.</font></font></p>
                    </li>
                </ol>

                <ol start="3">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">You are permitted to promote Boame</font></font><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">using only legal methods. Any fraudulent income promises or guarantees that are inconsistent with the information provided by Boame</font></font><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">may result in permanent account suspension and/or legal actions.</font></font></p>
                    </li>
                </ol>

                <ol start="4">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Boame will not be held responsible for any harm and/or loss made to any person or group by our members and/or visitors. Therefore; both members and visitors of Boame assume full responsibility for their methods of promoting and marketing Boame and you must be in full compliance to these written terms.</font></font></p>
                    </li>
                </ol>

                <ol start="5">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">The information, communications and/or any materials Boame</font></font><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">contains or provides are for educational and informational purposes only and is not to be regarded as solicitation </font></font><font color="#474747"><font face="Arial Narrow, serif"><font size="4">for investments in any jurisdiction which deems as non-public offers or unlawful solicitations nor to any person whom it will be unlawful to make such an offer and/or solicitation.</font></font></font></p>
                    </li>
                </ol>

                <ol start="6">
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Any inquiries should be addressed in writing to our support team via the contact page.</font></font></font></p>
                    </li>
                </ol>

                <p><br />
                <font color="#365f91"><font face="Arial Narrow, serif"><font size="4">OUR PRIVACY POLICY</font></font></font></p>

                <ol>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Boame considers your privacy protection is of the utmost importance in our relationship with our members. Boame will make every reasonable attempt to protect your personal data, such as your email address, payment processor IDs and e-wallet and treat them in a confidential manner. Boame will not sell or share your personal data and will make every effort to prevent unauthorized access to it.</font></font></font></p>
                    </li>
                </ol>

                <ol start="2">
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Boame</font></font></font><font color="#474747"><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font></font><font color="#474747"><font face="Arial Narrow, serif"><font size="4">guarantees that we will act prudent and be diligent in regards to keeping all transactions that are completed through your membership with Boame strictly confidential utilizing all reasonable measures to protect your information.</font></font></font></p>
                    </li>
                </ol>

                <ol start="3">
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Boame may collect certain non-public information about you during the process of providing any of our services or offers to you. In accordance with our privacy policy, we will keep any information protected and strictly confidential. Boame will not use this information for other purposes than for the provision of and improvement of our services and offers. Boame will not disclose this information to anyone unless otherwise is required by law.</font></font></font></p>
                    </li>
                </ol>

                <ol start="4">
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">Boame has implemented procedures that are up to date and best suited to protect the security and confidentiality of your information. These procedures include confidentiality agreements with third parties that assist us in providing services to you, password-protected user access to our computer files and strict confidentiality policies that apply to all Boame administrators</font></font></font><br />
                    <br />
                    &nbsp;</p>
                    </li>
                </ol>

                <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4"><em>Please carefully read our full Privacy Policy as it is a part of these Terms of Service</em></font></font></font><font color="#474747"><font face="Arial Narrow, serif"><font size="4"><strong>.</strong></font></font></font></p>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">BOAME</font></font></font><font color="#474747"><font face="inherit, serif"><font size="6">&nbsp;</font></font></font><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">&quot;ZERO-TOLERANCE&quot; ANTI-SPAM POLICY</font></font></font></p>

                <ol>
                    <li>
                    <p><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">Boame</font></font></font><font color="#474747"><font face="Arial, serif"><font size="2">&nbsp;</font></font></font><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">will not tolerate SPAM or any type of UCE. SPAM violators will be subject to a potential (TOS) violation which may result in revocation of your membership.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">Boame&nbsp;prohibits the sending of unsolicited mass e-mails or unsolicited e-mails of any kind in connection with the promotion and marketing of the services provided by&nbsp;Boame.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">Boame&nbsp;reserves the right to cooperate in any investigation relating to your activities including disclosure of your account information involving SPAM allegations. Should any law enforcement agency, internet provider, web hosting provider or other person or entity provide us with notice that you may have engaged in transmission of unsolicited e-mails or may have engaged in otherwise unlawful conduct or conduct in violation of any internet service provider&#39;s Terms of Service and their policies or regulations.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">It is advisable to check your Spam or Junk folders due to your email provider labeling our correspondence as Spam and add&nbsp;Boame</font></font></font><font color="#474747"><font face="Arial, serif"><font size="2">&nbsp;</font></font></font><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">to your &ldquo;white list&rdquo; for Trusted Senders </font></font></font><font face="Arial Narrow, serif"><font size="4">List to receive electronic mail from us.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">If it is determined that you have violated this &quot;Zero-Tolerance&quot; Anti-Spam Policy, you will subject to the Terms of Service violation provisions mandated by Boame</font></font><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">which includes revocation of your membership.</font></font></p>
                    </li>
                </ol>

                <p><br />
                &nbsp;</p>

                <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4"><em>Please carefully read our full Anti-Spam Policy as it is a part of these Terms of Service.</em></font></font></font></p>

                <p><br />
                &nbsp;</p>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">CUSTOMER SERVICE AND SUPPORT</font></font></font></p>

                <ol>
                    <li>
                    <p><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">All members of&nbsp;Boame&nbsp;have the right to request any additional information from our support team and administrators. We promise to act promptly and professionally when addressing your requests.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">All members of&nbsp;Boame&nbsp;will have the ability to contact our support service through our website support form, the live support service (when available), Facebook group administrators and contacting us with the listed company phone number.</font></font></font></p>
                    </li>
                    <li>
                    <p><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">As a member of&nbsp;Boame, you&nbsp;agree to act in a respectful and professional manner when contacting our support team and/or identified administrators. You also agree to follow these instructions that will prevent and avoid potential negative situations.</font></font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">ANTI-DDOS AND WEBSITE AVAILABILITY</font></font></font></p>

                <ol>
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4"><em>Distributed Denial of Service</em></font></font></font><font color="#474747"><font face="Arial Narrow, serif"><font size="4">&nbsp;(DDoS) is known as one of the most ubiquitous and damaging attacks in cyberspace. In response to the growing concern of DDoS attacks,&nbsp;the Boame</font></font></font><font color="#474747"><font face="Arial, serif"><font size="2">&nbsp;</font></font></font><font color="#474747"><font face="Arial Narrow, serif"><font size="4">website is hosted on a server that safeguards it from DDoS attacks and other attempts of intrusion.</font></font></font></p>
                    </li>
                </ol>

                <ol start="2">
                    <li>
                    <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4">These measures include&nbsp;a firewall, encryption, application proxies, monitoring technology, and adaptive analysis of the website&#39;s traffic to track abuse to&nbsp;maintain the integrity and stability of the&nbsp;Boame</font></font></font><font color="#474747"><font face="Arial, serif"><font size="2">&nbsp;</font></font></font><font color="#474747"><font face="Arial Narrow, serif"><font size="4">website allowing for consistent availability and minimal downtime.</font></font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">MAINTENANCE/DOWNTIME</font></font></font></p>

                <ol>
                    <li>
                    <p><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">Boame&nbsp;reserves the right to temporarily suspend access to this website without prior notice though we will make every effort to provide advance notification of any downtime. Downtime may be related to server maintenance, updating, deleting, and/or modifying of the&nbsp;Boame website content. Downtime may also be a result of unforeseen circumstances which include immediate system updates, power outages, equipment failure and/or natural disasters, etc.</font></font></font></p>
                    </li>
                </ol>

                <ol start="2">
                    <li>
                    <p><font color="#00000a"><font face="Arial Narrow, serif"><font size="4">Boame&nbsp;does not bear any responsibility for inconveniences or problems resulting from downtime and/or maintenance when members cannot access the website because of these reasons.</font></font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">RIGHT TO SUSPEND</font></font></font></p>

                <ol>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Boame reserves the right to suspend and/or close operations of this site or sections thereof when as a result of political, economic, military, monetary events and/or any other circumstances outside control, responsibility and power of the Boame website and company. The continued operation of this website is continued upon income margins being sufficient to cover operation expenses to allow for the continuance of conducting services in such event, Boame</font></font><font face="Times New Roman, serif"><font size="4">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">will provide updates and deliver services at all possible opportunities.</font></font></p>
                    </li>
                </ol>

                <p><br />
                <font color="#365f91"><font face="Arial Narrow, serif"><font size="4">LENDING RISKS WARNING</font></font></font></p>

                <ol>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">It may take longer time to have others donate to you. It is recommended for individuals and institutions to lend what they can afford to lose.</font></font></p>
                    </li>
                </ol>

                <ol start="2">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Any opinions expressed by representatives of Boame as to Lending are purely opinions, which do not necessarily represent the opinion of Boame and therefore, do not imply any guaranties.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">You acknowledge that there are risks associated with utilizing an Internet-based deal execution trading system which include but are not limited to the failure of hardware, software, and Internet connections.</font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">AMENDMENTS TO THESE TERMS OF SERVICE</font></font></font></p>

                <ol>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">The administration of&nbsp;Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">reserves the right to amend these &quot;Terms of Service&rdquo; without our members&rsquo; consent.</font></font></p>
                    </li>
                </ol>

                <ol start="2">
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">The administration of&nbsp;Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">will inform its members of any made to these &ldquo;Terms of Service&rdquo; by publishing an information notice on the Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">website.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Any amendments will become effective on the date of placing the information on&nbsp;Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">website unless otherwise provided in the text of any specific notice, email, written letter or any other form of communication to its members.</font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">TERMS OF SERVICES (TOS) VIOLATION&nbsp;AND YOUR MEMBERSHIP</font></font></font></p>

                <ol>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">The administration of &ldquo;Terms of Service&rdquo; reserves the right to revoke membership, access and/or services based upon any proven violations of any of these &ldquo;Terms of Service&rdquo; by any member of&nbsp;Boame.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">Any type of violation of our &ldquo;Terms of Service&rdquo; mentioned and/or described within may be causation for your Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">membership to be revoked. If your account is revoked, you will lose any right to use any Boame</font></font><font face="Arial, serif"><font size="2">&nbsp;</font></font><font face="Arial Narrow, serif"><font size="4">services and/or offers.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">You agree that if your membership is revoked, your active package and actual account balance will be refunded to you. You will lose all direct referrals and no longer receive earnings from the activities of your downlines.</font></font></p>
                    </li>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">You may appeal any revocation of your membership by sending a written communication to the administration of&nbsp;Boame and provide your reasons for reinstatement. There are no guarantees that your privileges will be reinstated and your membership restored. All decisions made will be at the discretion of the Boame administration and on an individual basis.</font></font></p>
                    </li>
                </ol>

                <p><font color="#365f91"><font face="Arial Narrow, serif"><font size="4">ARBITRATION</font></font></font></p>

                <ol>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">In cases where any provision of these &quot;Terms of Service&quot; are determined by a court of competent jurisdiction or an arbitration body to be unenforceable in certain jurisdictions, the provision shall be acknowledged as unenforceable in such jurisdictions.</font></font></p>
                    </li>
                </ol>

                <ol>
                    <li>
                    <p><font face="Arial Narrow, serif"><font size="4">All other provisions of these &quot;Terms of Service&quot; shall remain binding for all signatories as if the unenforceable provisions were not contained within. The other provisions shall remain enforceable and unaffected in all other jurisdictions.</font></font></p>
                    </li>
                </ol>

                <p><br />
                &nbsp;</p>

                <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4"><em>* The following terms have the same implied meaning for the purpose of these Terms of Service, &ldquo;Our,&rdquo; &ldquo;our,&rdquo; &ldquo;Us,&rdquo; &ldquo;us,&rdquo; &ldquo;We,&rdquo; &ldquo;we,&rdquo; &ldquo;BPoints&rdquo; and &ldquo;Boame&rdquo; in relationship to us.</em></font></font></font></p>

                <p><br />
                &nbsp;</p>

                <p><font color="#474747"><font face="Arial Narrow, serif"><font size="4"><em>* The following terms have the same implied meaning for the purpose of these Terms of Service, &ldquo;User,&rdquo; &ldquo;user,&rdquo; &ldquo;You,&rdquo; &ldquo;you,&rdquo; &ldquo;Your,&rdquo; &ldquo;your,&rdquo; &ldquo;member&rdquo; and &ldquo;Member&rdquo; in relationship to you, the member.</em></font></font></font></p>

                <p>&nbsp;</p>

            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
    </div>
 </div>

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
  $('#register_form').validate({
          rules: {
            first_name : { 
                  required :true,
            },
            last_name : { 
                  required :true,
              },
            username : { 
                required :true,
            },
            password : { 
                required :true,
            },
            confirm_password : { 
                required :true,
                equalTo: "#password"
            },
            referral_Code : { 
                required :true,
            },
            phone_number : {
              required : true, 
            },
            agree : 
            {
              required: true
            }
          },
          messages: {
              first_name : {
                 required : 'Please enter first name',
              },
              last_name : {
                 required : 'Please enter last name',
              },
              username : {
                required : 'Please enter username',
              },
              password : { 
                  required : 'Please enter password',
              },
              confirm_password : { 
                required :'Please confirm your password',
                equalTo: 'Your confirm password is not matching'
              },
              referral_Code : { 
                  required : 'Please enter Referral Code',
              },
              phone_number : { 
                  required : 'Please enter Phone number',
              },
              agree : { 
                  required : 'Select the terms and conditions',
              },
          }
      });

  $(document).on('change', '#referral_Code', function() {
    jQuery.ajax({
          url : '<?php echo BASE_URL ?>'+'user/referal_exist',
          method: 'post',
          data: {referral_code:$("#referral_Code").val() },
          dataType: 'json',
          success: function(response)
          {
            if (response == true)
            {
              $("#referral_error").hide();
            }
            else
            {
              $("#referral_error").show();
              $("#referral_Code").val('');
              $("#referral_Code").focus();
            }
            // $("#verification_code_error").hide();
            // $("#verifyed_success").hide();
            // $("#phone_number_error").hide();
            // $("#email_error").hide();
          }
        });
  });

   $(document).on('change', '#username', function() {
    jQuery.ajax({
          url : '<?php echo BASE_URL ?>'+'user/is_username_exist',
          method: 'post',
          data: {username:$("#username").val() },
          dataType: 'json',
          success: function(response)
          {
            if (response == true)
            {
              $("#email_error").show();
              $("#username").val('');
              $("#username").focus();
              
            }
            else
            {
              $("#email_error").hide();
            }
            // $("#referral_error").hide();
            // $("#verification_code_error").hide();
            // $("#verifyed_success").hide();
            // $("#phone_number_error").hide();
          }
        });
   });

   $(document).on('change', '#verification_code', function() {
    jQuery.ajax({
          url : '<?php echo BASE_URL ?>'+'verification/verify_session',
          method: 'post',
          data: { verification_code:$("#verification_code").val() },
          dataType: 'json',
          success: function(response)
          {
            if (response == 'true')
            {
                $("#verify_code").hide();
                $("#verification_code_error").hide();
                $("#verifyed_success").show();
            }
            else
            {
                $("#verification_code").focus();
                $("#verification_code").val('');
                $("#verify_code").show();
                $("#verification_code_error").show();
                $("#verifyed_success").hide();
                
            }
            // $("#referral_error").hide();
            // $("#phone_number_error").hide();
            // $("#email_error").hide();
          }
        });
   });

    $(document).on('change', '#phone_number', function() {
        $(".loading").show();
        jQuery.ajax({
            url : '<?php echo BASE_URL ?>'+'verification/callMethodSignup',
            method: 'post',
            data: {phone_number: $("#phone_number").intlTelInput("getNumber")},
            dataType: 'json',
            success: function(response)
            {
                $(".loading").hide();
                if (response == "true_number")
                {
                    $("#verify_code").show();
                    $("#phone_number_error").hide();
                }
                else
                {
                    $("#verify_code").hide();
                    $("#phone_number_error").show();
                }
                // $("#referral_error").hide();
                // $("#verifyed_success").hide();
                // $("#verification_code_error").hide();
                // $("#email_error").hide();
            }
        });
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
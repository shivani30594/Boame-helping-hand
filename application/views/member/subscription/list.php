
<section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">BOAME Forex</h3>
    <small>From here, User can choose one of the subscription plan and get access of Forex Robert.</small>
  </div>
</section>
  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <i class="fa fa-ok-sign"></i><?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <i class="fa fa-ok-sign"></i><?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('warning')): ?>
    <div class="alert alert-warning">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <i class="fa fa-ok-sign"></i><?= $this->session->flashdata('warning'); ?>
    </div>
<?php endif; ?>
<div class="row">
  <div class="col-sm-4 checkbox">
      <label><input type='checkbox' value="yes" name="auto_subscription" id="auto_sub_checkbox" <?php echo $member_details->auto_subscription == '1' ? 'checked' : '' ?>> Auto Subscription</label>
  </div>
  <div class="col-sm-6">
  </div>
  <div class="col-sm-2 text-right">
      <a class="btn btn-success" href="<?php echo BASE_URL?>subscription">Subscription History</a>
  </div>
</div>
<div class="subscription-wrap">
  <div class="row">
  <?php if(count($subscriptions) > 0):?>
      <?php foreach($subscriptions as $subscription):?>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="subscription-plan">
            <h1><?php echo $subscription->plan_name?></h1>
            <p><?php echo $subscription->plan_duration?></p>
            <p><?php echo substr($subscription->plan_description,0,200)?></p>
            <p class="price"><?php echo $subscription->plan_price?> <?php echo $subscription->plan_price_currency?></p>
            <a data-userid = "<?php echo $this->session->userdata('user_id')?>" data-price="<?php echo $subscription->plan_price?>" data-subscriptionid="<?php echo $subscription->id?>" data-currentid="<?php echo (isset($record) AND count($record)>0) ? $record[0]['subscription_id'] :''?>" data-toggle="modal" class="open-AddBookDialog" data-target="#activate_eproduct_choose">Select</a>
          </div>
      </div>
      <?php endforeach;?>
  <?php endif;?>
  </div>
</div>

<div class="modal fade" id="activate_eproduct_choose" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Payment Option</h4>
      </div>
      <div class="modal-body">
      <h4 style="color:#146ca4"><b>USD-bpoints:<?php echo isset($user_sec) ? $user_sec->total_bpoints_usd : ''?></b></h4>
      <p style="text-align:justify"> Notes: 
        <ul>
          <li> If you choose <b>Using BPoints</b>, it will deduct the subscription amount from your "USD-Bpoints". But if, you choose <b>Pay online</b>, then we will redirect you to pay amount using CoinPayment.</i></li>
          <li> Upgraded will be reflected once your current plan is expired.</li>
          <li> On successful subcription, ForexRobot.zip will be downloaded automatically in your machine.It will be downloaded only once when you subscribed for the first time</li>
        </ul>
      </p>
          <div class="container">
            <div id="text_content">
            </div>
          </div>
          <br>
          <div class="row">
            <input type="hidden" value="" id="plan_id" name="plan_id"/>
            <div class="col-sm-4">
              <div class="btn-group"> 
                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"> 
                  <span class="dropdown-label">Select Payment Option</span> <span class="caret"></span> 
                </button> 
                <ul class="dropdown-menu dropdown-select"> 
                  <li><a href="#" class="option"><input type="radio" name="b" value="ghs_bpoints">GHS bPoints</a></li> 
                  <li><a href="#"><input type="radio" name="b" value="usd_bpoints">USD bPoints</a></li> 
                  <li><a href="#"><input type="radio" name="b" value="ghs_ewallet">GHS eWallet</a></li> 
                  <li><a href="#"><input type="radio" name="b" value="usd_ewallet">USD eWallet</a></li> 
                </ul> 
              </div>
            </div>
            <div class="col-sm-4">
              <form action="https://www.coinpayments.net/index.php" method="post">
               <input type="hidden" name="cmd" value="_pay_simple">
                <input type="hidden" name="reset" value="1">
                <input type="hidden" name="merchant" value="<?php echo config_setting_item('merchant_id')?>">
                <input type="hidden" name="item_name" value="Boame Forex">
                <input type="hidden" name="currency" value="USD">
                <input type="hidden" id="amountf" name="amountf" value="5.00000000">
                <input type="hidden" name="want_shipping" value="0">
                <input type="hidden" id="user_id" name="custom" value="">
                <input type="hidden" name="success_url" value="<?php echo SUCCESS_URL;?>">
                <input type="hidden" name="cancel_url" value="<?php echo CANCEL_URL;?>">
                <input type="hidden" name="ipn_url" value="<?php echo PAY_FOR_ROBOT_URL;?>">
                <input type="image" id="pay_online" src="https://www.coinpayments.net/images/pub/buynow-wide-blue.png" alt="Buy Now with CoinPayments.net">
            </form>
            </div>
          </div>
      </div>
  </div>
</div>
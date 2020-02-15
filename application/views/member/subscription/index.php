<section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">BOAME Forex Activation History</h3>
    <small>From here, User can see the subscription history with starting and expiration date. Also,provide provision for Upgarde Plan.Also, apply for auto-subscription from here.</auto-subscription></small>
    <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#myModal">Risk Discloser</button>
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
    <?php if ((isset($record)) AND count($record)>0 AND $record[0]['status'] == 'complete'):?>
      <h5 class="text-primary">Your current activated plan will be expired on : <?php echo isset($record) ? date('M d,Y h:i A',strtotime($record[0]['end_date'])) : '' ?></h5>
    <?php else:?>
      <h5 class="text-danger">Your subscription plan was expired .</h5>
    <?php endif;?>
  </div>
  <div class="col-sm-2 text-right">
      <a class="btn btn-primary" href="<?php echo BASE_URL?>list_plan">Upgrade Plan</a>
  </div>
</div>
  <div class="table-responsive">
      <table class="table table-striped m-b-none" id="sub_history">
        <thead>
          <tr>
              <th>Plan Name</th>
              <th>Plan Desciption</th>
              <th>Plan Price</th>
              <th>Activated Using</th>
              <th>Address</th>
              <th>Plan Status</th>
              <th>Plan Started</th>
              <th>Plan ended</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Risk Discloser</h4>
        </div>
        <div class="modal-body">
        <p>Client understands that the risk of suffering trading losses may be quite significant. Client should analyze his financial capabilities before engaging in trading operations.</p>

        <p>Client realizes that he may completely lose his all initial funds and any additional funds used when trading on the market.</p>

        <p>Client agrees that the company cannot be held responsible for client's losses caused, directly or indirectly, by the government restrictions, restrictions of foreign exchange or market rules, suspension of trading, military operations, or other conditions usually called the ‘force majeure circumstances' which lie beyond the company's control.</p>

        <p>Client was informed about additional risks associated with the specifics of functioning of e-trade systems and the problems of Internet communication nodes.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
<div class="modal fade" id="activate_eproduct_choose" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Notification</h4>
      </div>
      <div class="modal-body">
      <h4 style="color:#146ca4"><b>USD-bpoints:<?php echo isset($user_sec) ? $user_sec->total_bpoints_usd : ''?></b></h4>
      <p style="text-align:justify"><i>Note: If you choose <b>Using BPoints</b>, it will deduct the subscription amount from your "USD-Bpoints". But if, you choose <b>Pay online</b>, then we will redirect you to pay amount using CoinPayment.</i></p>
          <div class="row">
            <div class="col-sm-3">
                <input type="hidden" value="" id="plan_id" name="plan_id"/>
                <input type="hidden" value="using_bpoints" id="payment_mode" name="payment_mode"/>
                <input id="bpoints_Btn" style="line-height: 26px;" type="submit" class="btn btn-success" value="Using Bpoints">
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
                <input type="hidden" id="user_id" name="custom" value="<?php echo $this->session->userdata('user_id');?>">
                <input type="hidden" name="success_url" value="<?php echo SUCCESS_URL?>">
                <input type="hidden" name="cancel_url" value="<?php echo CANCEL_URL?>">
                <input type="hidden" name="ipn_url" value="<?php echo PAY_FOR_ROBOT_URL?>">
                <input type="image" id="pay_online" src="https://www.coinpayments.net/images/pub/buynow-wide-blue.png" alt="Buy Now with CoinPayments.net">
              </form>
            </div>
          </div>
      </div>
  </div>
</div>

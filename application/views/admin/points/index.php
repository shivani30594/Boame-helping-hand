  <section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">Point Transaction History</h3>
    <small>You can see Point transaction history which contains purchased points, Net referral bonus, Net power bonus, Net Matching bonus and Net earnings from registered date to till now!!</small>
  </div>
</section>
<div class="col-sm-2"><label for=""><b>Full name:</b> <?php echo $user_details->first_name .' '.$user_details->last_name?></label></div>
<div class="col-sm-offset-6"><label><b>Registered Date:</b> <?php echo date('M d,Y', strtotime($user_details->created))?></div>
<div class="row" id="single_point_history">
      <div class="col-md-8">
      <!-- Nav tabs -->
        <div class="card">
          <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#ghs" aria-controls="home" role="tab" data-toggle="tab">GHS-bPoints </a></li>
              <li role="presentation"><a href="#usd" aria-controls="profile" role="tab" data-toggle="tab">USD-bPoints</a></li>
              <li role="presentation"><a href="#referral" aria-controls="messages" role="tab" data-toggle="tab">Net Referral Bonus</a></li>
              <li role="presentation"><a href="#power" aria-controls="settings" role="tab" data-toggle="tab">Net Power Bonus</a></li>
              <li role="presentation"><a href="#matching" aria-controls="settings" role="tab" data-toggle="tab">Net Matching Bonus</a></li>
              <li role="presentation"><a href="#earnings" aria-controls="settings" role="tab" data-toggle="tab">Net Earnings</a></li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="ghs"><?php echo isset($total_purchased_points) ? number_format((float)$total_purchased_points, 2, '.', '')  : '0'?></div>
              <div role="tabpanel" class="tab-pane " id="usd"><?php echo isset($total_purchased_usd_points) ? number_format((float)$total_purchased_usd_points, 2, '.', '') : '0'?></div>
              <div role="tabpanel" class="tab-pane " id="referral"><?php echo isset($total_referral_bonus) ? number_format((float)$total_referral_bonus, 2, '.', '') : '0'?></div>
              <div role="tabpanel" class="tab-pane " id="power"><?php echo isset($total_power_bonus) ? number_format((float)$total_power_bonus, 2, '.', '') : '0'?></div>
              <div role="tabpanel" class="tab-pane " id="matching"><?php echo isset($total_matching_bonus) ? number_format((float)$total_matching_bonus, 2, '.', '') : '0'?></div>
              <div role="tabpanel" class="tab-pane " id="earnings"><?php echo isset($ewallet) ? number_format((float)$ewallet, 2, '.', '') : '0'?></div>
          </div>
      </div>
    </div>
  </div>
</div>

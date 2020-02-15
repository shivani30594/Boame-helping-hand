  <section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">Point Transaction Report</h3>
    <small>Here is the report of point transactions for all the registered member!!</small>
  </div>
</section>
<!-- <div class="col-sm-12">
  <div class="panel panel-default">
        <ul class="nav nav-tabs font-bold" style="width: 100%;">
            <li class="active tab" style="width: 20%;">
                <a href="#home-21" data-toggle="tab" aria-expanded="false" class="active">
                    <span class="visible-xs"><i class="fa fa-home"></i></span>
                    <span class="hidden-xs">Points Purchases</span>
                </a>
            </li>
            <li class="tab" style="width: 20%;">
                <a href="#profile-21" data-toggle="tab" aria-expanded="false">
                    <span class="visible-xs"><i class="fa fa-user"></i></span>
                    <span class="hidden-xs">Net Referral Bonus</span>
                </a>
            </li>
            <li class="tab" style="width: 20%;">
                <a href="#messages-21" data-toggle="tab" aria-expanded="true">
                    <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                    <span class="hidden-xs">Net Power Bonus</span>
                </a>
            </li>
            <li class="tab" style="width: 20%;">
                <a href="#settings-21" data-toggle="tab" aria-expanded="false">
                    <span class="visible-xs"><i class="fa fa-cog"></i></span>
                    <span class="hidden-xs">Net Matching Bonus</span>
                </a>
            </li>
            <li class="tab" style="width: 20%;">
                <a href="#earnings-21" data-toggle="tab" aria-expanded="false">
                    <span class="visible-xs"><i class="fa fa-cog"></i></span>
                    <span class="hidden-xs">Net Earnings</span>
                </a>
            </li>
        <div class="indicator" style="right: 515px; left: 0px;"></div></ul>
        <div class="tab-content">
            <div class="tab-pane active" id="home-21" style="padding:30px">
              <div class="text-center">
                <h3> <?php echo isset($total_purchased_points) ? $total_purchased_points : '0'?></h1>
              </div>
            </div>
            <div class="tab-pane" id="profile-21" style="padding:30px">
              <div class="text-center">
                <h3><?php echo isset($total_referral_bonus) ? $total_referral_bonus : '0'?> </h1>
              </div>
            </div>
            <div class="tab-pane" id="messages-21" style="padding:30px">
              <div class="text-center">
                <h3><?php echo isset($total_power_bonus) ? $total_power_bonus : '0'?></h1>
              </div>
            </div>
            <div class="tab-pane" id="settings-21" style="padding:30px">
              <div class="text-center">
                <h3><?php echo isset($total_matching_bonus) ? $total_matching_bonus : '0'?></h1>
              </div>
            </div>
            <div class="tab-pane" id="earnings-21" style="padding:30px">
              <div class="text-center">
                <h3><?php echo isset($ewallet) ? $ewallet : '0'?></h1>
              </div>
            </div>
        </div>
    </div>
</div> -->
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

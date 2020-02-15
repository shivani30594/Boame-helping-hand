<section class="row m-b-md">
	<div class="col-sm-6">
	  <h3 class="m-b-xs text-black">Dashboard</h3>
	  <small>Welcome back, <?php echo $admin_details->first_name . ' ' .  $admin_details->last_name?></small>
	</div>
</section>
 <div class="row">
    <div class="col-sm-3">
      <div class="panel b-a">
          <div class="row m-n">
          <div class="col-md-12 b-b b-r">
            <a class="block padder-v hover">
              <span class="i-s i-s-2x pull-left m-r-sm">
                <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                <i class="fa fa-users i-1x text-white"></i>
              </span>
              <span class="clear">
                <span class="h3 block m-t-xs text-danger"><?php echo isset($total_active_users) ? $total_active_users : '0'?></span>
                <small class="text-muted text-u-c">Active Users</small>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="panel b-a">
          <div class="row m-n">
          <div class="col-md-12 b-b b-r">
            <a class="block padder-v hover">
              <span class="i-s i-s-2x pull-left m-r-sm">
                <i class="i i-hexagon2 i-s-base text-info hover-rotate"></i>
                <i class="fa fa-users i-1x text-white"></i>
              </span>
              <span class="clear">
                <span class="h3 block m-t-xs text-info"><?php echo isset($total_registered_users) ? $total_registered_users : '0'?></span>
                <small class="text-muted text-u-c">Registerred Users</small>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="panel b-a">
          <div class="row m-n">
          <div class="col-md-12 b-b b-r">
            <a class="block padder-v hover">
              <span class="i-s i-s-2x pull-left m-r-sm">
                <i class="i i-hexagon2 i-s-base text-default hover-rotate"></i>
                <i class="fa fa-gift i-1x text-white"></i>
              </span>
              <span class="clear">
                <span class="h3 block m-t-xs text-default"><?php echo isset($total_purchased_points) ? number_format((float)$total_purchased_points, 2, '.', '') : '0'?></span>
                <small class="text-muted text-u-c">Net GHSbPoints</small>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="panel b-a">
          <div class="row m-n">
            <div class="col-md-12 b-b b-r">
              <a class="block padder-v hover">
                <span class="i-s i-s-2x pull-left m-r-sm">
                  <i class="i i-hexagon2 i-s-base text-success hover-rotate"></i>
                  <i class="fa fa-exchange i-1x text-white"></i>
                </span>
                <span class="clear">
                  <span class="h3 block m-t-xs text-success"><?php echo isset($total_purchased_usd_points) ? number_format((float)$total_purchased_usd_points, 2, '.', '') : '0'?></span>
                  <small class="text-muted text-u-c">Net USDbPoints</small>
                </span>
              </a>
            </div>
          </div>
      </div>
    </div>
 </div>
  <div class="row">
    <div class="col-sm-3">
      <div class="panel b-a">
          <div class="row m-n">
            <div class="col-md-12 b-b b-r">
              <a class="block padder-v hover">
                <span class="i-s i-s-2x pull-left m-r-sm">
                  <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                  <i class="fa fa-exchange i-1x text-white"></i>
                </span>
                <span class="clear">
                  <span class="h3 block m-t-xs text-primary"><?php echo isset($total_pending_withdrawals) ? number_format((float)$total_pending_withdrawals, 2, '.', '') : '0'?></span>
                  <small class="text-muted text-u-c">Total pending withdrawals</small>
                </span>
              </a>
            </div>
          </div>
        </div>
     </div>
     <div class="col-sm-3">
      <div class="panel b-a">
          <div class="row m-n">
            <div class="col-md-12 b-b b-r">
              <a class="block padder-v hover">
                <span class="i-s i-s-2x pull-left m-r-sm">
                  <i class="i i-hexagon2 i-s-base text-warning hover-rotate"></i>
                  <i class="fa fa-exchange i-1x text-white"></i>
                </span>
                <span class="clear">
                  <span class="h3 block m-t-xs text-warning"><?php echo isset($net_withdrawal) ? number_format((float)$net_withdrawal, 2, '.', '') : '0'?></span>
                  <small class="text-muted text-u-c">Net withdrawals</small>
                </span>
              </a>
            </div>
          </div>
      </div>
    </div>
     <div class="col-sm-3">
      <div class="panel b-a">
          <div class="row m-n">
          <div class="col-md-12 b-b b-r">
            <a class="block padder-v hover">
              <span class="i-s i-s-2x pull-left m-r-sm">
                <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                <i class="fa fa-google-wallet i-1x text-white"></i>
              </span>
              <span class="clear">
                <span class="h3 block m-t-xs text-danger"><?php echo isset($total_ewallets) ? number_format((float)$total_ewallets, 2, '.', '') : '0'?></span>
                <small class="text-muted text-u-c">Net GHSeWallet Balance</small>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="panel b-a">
          <div class="row m-n">
            <div class="col-md-12 b-b b-r">
              <a class="block padder-v hover">
                <span class="i-s i-s-2x pull-left m-r-sm">
                  <i class="i i-hexagon2 i-s-base text-info hover-rotate"></i>
                  <i class="fa fa-exchange i-1x text-white"></i>
                </span>
                <span class="clear">
                  <span class="h3 block m-t-xs text-info"><?php echo isset($total_ewallet_usd) ? number_format((float)$total_ewallet_usd, 2, '.', '') : '0'?></span>
                  <small class="text-muted text-u-c">Net USDeWallet Balance</small>
                </span>
              </a>
            </div>
          </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="panel b-a">
          <div class="row m-n">
          <div class="col-md-12 b-b b-r">
            <a class="block padder-v hover">
              <span class="i-s i-s-2x pull-left m-r-sm">
                <i class="i i-hexagon2 i-s-base text-default hover-rotate"></i>
                <i class="fa  fa-trophy i-1x text-white"></i>
              </span>
              <span class="clear">
                <span class="h3 block m-t-xs text-default"><?php echo isset($total_power_bonus) ? number_format((float)$total_power_bonus, 2, '.', '') : '0'?></span>
                <small class="text-muted text-u-c">Net Power Bonus</small>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="panel b-a">
          <div class="row m-n">
          <div class="col-md-12 b-b b-r">
            <a class="block padder-v hover">
              <span class="i-s i-s-2x pull-left m-r-sm">
                <i class="i i-hexagon2 i-s-base text-success hover-rotate"></i>
                <i class="fa fa-trophy i-1x text-white"></i>
              </span>
              <span class="clear">
                <span class="h3 block m-t-xs text-success"><?php echo isset($total_matching_bonus) ? number_format((float)$total_matching_bonus, 2, '.', '') : '0'?></span>
                <small class="text-muted text-u-c">Net Matching Bonus</small>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="panel b-a">
          <div class="row m-n">
          <div class="col-md-12 b-b b-r">
            <a class="block padder-v hover">
              <span class="i-s i-s-2x pull-left m-r-sm">
                <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                <i class="fa fa-trophy i-1x text-white"></i>
              </span>
              <span class="clear">
                <span class="h3 block m-t-xs text-primary"><?php echo isset($total_referral_bonus) ? number_format((float)$total_referral_bonus, 2, '.', '') : '0'?></span>
                <small class="text-muted text-u-c">Net Referral Bonus</small>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="panel b-a">
          <div class="row m-n">
          <div class="col-md-12 b-b b-r">
            <a class="block padder-v hover">
              <span class="i-s i-s-2x pull-left m-r-sm">
                <i class="i i-hexagon2 i-s-base text-warning hover-rotate"></i>
                <i class="fa fa-gift i-1x text-white"></i>
              </span>
              <span class="clear">
                <span class="h3 block m-t-xs text-warning"><?php echo isset($ewallet) ? number_format((float)$ewallet, 2, '.', '') : '0'?></span>
                <small class="text-muted text-u-c">Net Earnings</small>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
</div>

</div>


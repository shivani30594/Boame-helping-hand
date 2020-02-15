<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Dashboard</h3>
    <small>Welcome back, <?php echo $member_details->first_name . ' ' .  $member_details->last_name?></small>
  </div>
</section>
<?php if ($this->session->flashdata('danger')): ?>
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <i class="fa fa-ok-sign"></i><?= $this->session->flashdata('danger'); ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <i class="fa fa-ok-sign"></i><?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>
<div class="row ">
  <div class="col-lg-6 text-left">
      <span class="label bg-info" style="display: inline-block; padding: 6px 12px; margin-bottom: 0;font-size: 14px;font-weight: normal;line-height: 1.42857143;
        text-align: center; color: #fff !important; white-space: nowrap; vertical-align: middle; margin-bottom:15px; font-size:15px">Referral Code: <?php echo $referral_code?></span>
  </div>
  <div class="col-lg-6 text-right">
    <!--<a data-toggle="modal" data-target="#myModal" class="btn btn-info" style="margin-bottom:15px">Pledge</a>-->
   
     <?php if(isset($user_info) && $user_info->is_eproduct_plan == 0) { ?>
      <a class="btn btn-info" style="margin-bottom:15px" data-toggle="modal" data-target="#activate_eproduct_choose">Activate eProduct Plan</a>
    <?php } else { ?>
    <a class="btn btn-primary" style="margin-bottom:15px" href="<?php echo BASE_URL ?>eProducts">eProducts Plan Activated</a>
    <?php } ?>
    <a class="btn btn-info" id="activate_eproduct_plan_ref_a" href="<?php echo BASE_URL ?>member/eproducts/activate_referral" style="margin-bottom:15px">Activate eProduct Plan By Referral</a>
  </div>   
</div>
<div class="row">
  <div class="col-lg-8">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel b-a">
          <div class="row m-n">
            <div class="col-md-6 b-b b-r">
              <a class="block padder-v hover">
                <span class="i-s i-s-2x pull-left m-r-sm">
                  <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                  <i class="glyphicon glyphicon-gift i-1x text-white"></i>
                </span>
                <span class="clear">
                  <span class="h3 block m-t-xs text-danger"><?php echo isset($total_referral_bonus) ? number_format((float)$total_referral_bonus, 2, '.', '') :'0' ?></span>
                  <small class="text-muted text-u-c">Referreal Bonus</small>
                </span>
              </a>
            </div>
            <div class="col-md-6 b-b b-r">
              <a  class="block padder-v hover">
                <span class="i-s i-s-2x pull-left m-r-sm">
                  <i class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
                  <i class="fa fa-trophy i-sm text-white"></i>
                </span>
                <span class="clear">
                  <span class="h3 block m-t-xs text-success"><?php echo isset($total_power_bonus) ? number_format((float)$total_power_bonus, 2, '.', '') : '0'?></span>
                  <small class="text-muted text-u-c">Power Bonus</small>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="panel b-a">
            <div class="row m-n">
            <div class="col-md-6 b-b b-r">
              <a  class="block padder-v hover">
                <span class="i-s i-s-2x pull-left m-r-sm">
                  <i class="i i-hexagon2 i-s-base text-dark hover-rotate"></i>
                  <i class="i i-plus2 i-1x text-white"></i>
                </span>
                <span class="clear">
                  <span class="h3 block m-t-xs text-dark"><?php echo isset($total_matching_bonus) ? number_format((float)$total_matching_bonus, 2, '.', '') :'0' ?></span>
                  <small class="text-muted text-u-c">Matching Bonus</small>
                </span>
              </a>
            </div>
            <div class="col-md-6 b-r">
              <a  class="block padder-v hover">
                <span class="i-s i-s-2x pull-left m-r-sm">
                  <i class="i i-hexagon2 i-s-base text-primary-lt hover-rotate"></i>
                  <i class="fa fa-users"></i>
                </span>
                <span class="clear">
                  <span class="h3 block m-t-xs text-primary"><?php echo isset($total_followers) ? $total_followers :'0' ?></span>
                  <small class="text-muted text-u-c">Followers</small>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="panel b-a">
            <div class="row m-n">
            <div class="col-md-6 b-r">
              <a  class="block padder-v hover">
                <span class="i-s i-s-2x pull-left m-r-sm">
                  <i class="i i-hexagon2 i-s-base text-info-lt hover-rotate"></i>
                  <i class="fas fa-exchange-alt i-sm text-white"></i>
                </span>
                <span class="clear">
                  <span class="h3 block m-t-xs text-info"><?php echo isset($total_pending_withdrawals) ? number_format((float)$total_pending_withdrawals, 2, '.', '') :'0' ?></span>
                  <small class="text-muted text-u-c">Pending Withdrawal</small>
                </span>
              </a>
            </div>
            <div class="col-md-6 b-r">
              <a  class="block padder-v hover">
                <span class="i-s i-s-2x pull-left m-r-sm">
                  <i class="i i-hexagon2 i-s-base text-warning-lt hover-rotate"></i>
                  <i class="far fa-money-bill-alt"></i>
                </span>
                <span class="clear">
                  <span class="h3 block m-t-xs text-warning"><?php echo isset($net_withdrawal) ? number_format((float)$net_withdrawal, 2, '.', '') :'0' ?></span>
                  <small class="text-muted text-u-c">Net Withdrawal</small>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="panel b-a">
            <div class="row m-n">
            <div class="col-md-6 b-r">
              <a  class="block padder-v hover">
                <span class="i-s i-s-2x pull-left m-r-sm">
                  <i class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
                  <i class="fa fa-usd"></i>
                </span>
                <span class="clear">
                  <span class="h3 block m-t-xs text-success"><?php echo isset($ewallet_usd) ? number_format((float)$ewallet_usd, 2, '.', '') :'0' ?></span>
                  <small class="text-muted text-u-c">USDeWallet</small>
                </span>
              </a>
            </div>
            <div class="col-md-6 b-b b-r">
              <a  class="block padder-v hover">
                <span class="i-s i-s-2x pull-left m-r-sm">
                  <i class="i i-hexagon2 i-s-base text-primary-lt hover-rotate"></i>
                  <i class="fab fa-google-wallet i-sm text-white"></i>
                </span>
                <span class="clear">
                  <span class="h3 block m-t-xs text-primary"><?php echo isset($ewallet) ? number_format((float)$ewallet, 2, '.', '') :'0' ?></span>
                  <small class="text-muted text-u-c">GHSeWallet</small>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" >
      <div class="col-sm-12">
        <div class="panel b-a">
            <div class="row m-n">
              <div class="col-md-2">
                <h4>Referral Link:</h4>
              </div>
              <div class="col-md-5">
                <h4 id="referral_link"><?php echo $referral_link?></h4>
              </div>
              <div class="col-md-3" style="margin-top:2px">
                <button class="btn btn-info" onclick="copyToClipboard('#referral_link')" id="copy_to_clipboard">Copy to clipboard</button>
              </div>
            <!-- <div class="col-md-6 b-r">
              <a  class="block padder-v hover">
              <h4>Referral Link:</h4>
              <div class="clear">
                <small class="block text-muted" id="referral_link"><?php echo $referral_link?></small>
                <button class="btn btn-xs btn-info m-t-xs" onclick="copyToClipboard('#referral_link')" id="copy_to_clipboard">Copy to clipboard</button>
              </div>
              </a>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
   <div class="col-lg-4">
      <section class="panel panel-default">
        <div class="panel-body">
          <div class="clearfix text-center m-t">
            <div class="inline">
              <div class="" style="width: 134px; height: 134px; line-height: 134px;">
                <div class="thumb-lg">
                  <img src="<?php echo (isset($member_details) AND $member_details->picture != '') ? $member_details->picture : ADMIN_IMAGES.'default-icon.png' ?>" class="img-circle" alt="">
                </div>
              <canvas width="147" height="147" style="width: 134px; height: 134px;"></canvas></div>
              <div class="h4 m-t m-b-xs"><?php echo $member_details->first_name . ' ' .  $member_details->last_name?></div>
              <small class="text-muted m-b"><i class="fas fa-phone-volume"><?php echo ' +'.$member_details->mtn_mobile_number?></i></small>
            </div>                      
          </div>
        </div>
        <footer class="panel-footer bg-info text-center">
          <div class="row pull-out">
            <div class="col-xs-6">
              <div class="padder-v">
                <span class="m-b-xs h3 block text-white"><?php echo isset($total_bpoints_usd) ? number_format((float)$total_bpoints_usd, 2, '.', '') :'0' ?></span>
                <strong><small class="text-muted">USD-bPoints</small></strong>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="padder-v">
                <span class="m-b-xs h3 block text-white"><?php echo isset($bpoints) ? number_format((float)$bpoints, 2, '.', '')  : '0'?></span>
                <strong><small class="text-muted">GHS-bPoints</small></strong>
              </div>
            </div>
          </div>
        </footer>
      </section>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <section class="panel panel-default">
          <div class="panel-body">
             <h4> MTN Information </h4>
             <div class="row">
             <div class="col-sm-6">
               <div class="alert alert-danger" style="display:none" id="alert_div">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <i class="fa fa-ban-circle"></i><strong>Oh sorry! </strong><span id="error_span"></span>
                </div>
                <div class="alert alert-success" style="display:none" id="success_div">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <i class="fa fa-ban-circle"></i><strong>Well done!! </strong><span id="success_span"></span>
                </div>
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <i class="fa fa-ok-sign"></i><?= $this->session->flashdata('success'); ?>.
                    </div>
                <?php endif; ?> 
             </div>
             </div>
            <div class="clearfix m-t">
              <form class="form-inline" role="form"  data-validate="parsley" method="post" action="<?php echo BASE_URL;?>member/dashboard/edit_mtn_detail" id="edit_mtn_form">
                <div class="form-group">
                  <label class="" for="exampleInputEmail2">MTN account number</label>
                  <input type="tel" class="form-control" id="phone_number" name="mtn_mobile_number" value="<?php echo '+'.$user_info->mtn_mobile_number?>" placeholder="MTN Account Number">
                </div>
                <div class="form-group" id="verify_code" style="display:none">
                <label class="col-sm-3 control-label">Verification code:</label>
                <div class="col-sm-9">
                  <input type="text" data-type="phone" required class="form-control parsley-validated" id="verification_code" name="verification_code" placeholder="Verification code">
                </div>
                </div>
                <div class="form-group">
                  <label class="" for="exampleInputPassword2">MTN account name</label>
                  <input type="text" class="form-control" id="mtn_mobile_name" name="mtn_mobile_name" value="<?php echo $user_info->mtn_mobile_name?>" placeholder="MTN Account Name">
                </div>
                <button type="submit" class="btn btn-success">Edit MTN</button>
                <div class="form-group">
                  <label class="col-sm-3 control-label"></label>
                  <div class="col-sm-9">
                    <label for="" id="phone_error_label" style="display:none;color:red">Please enter the valid phone number</label>
                  </div>
                </div>
                <div class="form-group" id="error_div" style="display:none;">
                  <label class="col-sm-3 control-label"></label>
                  <div class="col-sm-9">
                    <label for="" id="verification_error_label" style="display:none; color:red">Please try again later. Your MTN number is not verified.</label>
                    <label for="" id="verification_success_label" style="display:none; color:#179877">Your MTN number is verified.</label>
                    <label for="" id="verification_label" style="display:none;color:red">Please enter the valid verification code</label>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </section>
    </div>
</div>
<!-- <div class="row">
  <div class="col-sm-6">
    <section class="panel b-a panel-success">
      <div class="panel-heading b-b ">
        <a href="#" class="font-bold">Matching users from whom you are able to get GHS100</a>
      </div>
      <ul class="list-group list-group-lg no-bg auto"> 
        <?php if (isset($matching_details) AND (count($matching_details) > 0) ): ?>
      <?php foreach ($matching_details as $key => $value) { ?>
      <?php $class_name = $value->is_confirmed == 'Y' ? 'on' : 'busy'?>
        <a href="#" class="list-group-item clearfix">
          <span class="pull-left thumb-sm avatar m-r">
            <img src="<?php echo $value->picture?>" alt="...">
            <i class="<?php echo $class_name?> b-white bottom"></i>
          </span>
         <div class="pull-right media-xs text-center text-muted">
            <h4>
              <a class="btn btn-default" href = "<?php echo BASE_URL.'pledge_confirm/'.$value->pledge_id?>" data-toogle="" title="Confirmation"><i class="fa fa-check"></i></a>
            <h4>
          </div> 
          <span class="clear">
            <span><b><?php echo $value->first_name.' '.$value->last_name ?></b></span>
            <small class="text-muted clear text-ellipsis"><i class="fa fa-edit"></i> <?php echo $value->pledge_type?></small>
            <small class="text-muted clear text-ellipsis"><i class="fa fa-tasks"></i> <?php echo $value->pledge_title?></small>
            <small class="text-muted clear text-ellipsis"><i class="fa fa-phone"></i> <?php echo $value->mtn_mobile_number?></small>
            <small class="text-muted clear text-ellipsis"><i class="glyphicon glyphicon-time"></i> <?php echo $value->start_date?></small>
          </span>
        </a>
      <?php } ?> 
      <?php else: ?>
        <span style="line-height: 42px;margin:10px"> No users found.</span>
      <?php endif; ?>                        
      </ul>
    </section>
  </div>
   <div class="col-sm-6">
    <section class="panel b-a panel-info">
      <div class="panel-heading b-b ">
        <a href="#" class="font-bold">Matching user to whom you have to pay GHS100</a>
      </div>
      <ul class="list-group list-group-lg no-bg auto">
      <?php if (isset($my_matching_details) AND (count($my_matching_details) > 0)) : ?>
      <?php foreach ($my_matching_details as $key => $value) { ?>
      <?php $class_name = $value->is_confirmed == 'Y' ? 'on' : 'busy'?>
        <a href="#" class="list-group-item clearfix">
          <span class="pull-left thumb-sm avatar m-r">
            <img src="<?php echo $value->picture?>" alt="...">
            <i class="<?php echo $class_name?> b-white bottom"></i>
          </span>
          <span class="clear">
            <span><b><?php echo $value->first_name.' '.$value->last_name ?><b></span>
            <small class="text-muted clear text-ellipsis"><i class="fa fa-edit"></i><?php echo $value->pledge_type?></small>
            <small class="text-muted clear text-ellipsis"><i class="fa fa-tasks"></i><?php echo $value->pledge_title?></small>
            <small class="text-muted clear text-ellipsis"><i class="fa fa-phone"></i><?php echo $value->mtn_mobile_number?></small>
          </span>
        </a>
      <?php } ?>   
      <?php else: ?>
        <span style="line-height: 42px;margin:10px"> No users found.</span>
      <?php endif; ?>                         
      </ul>
    </section>
  </div>
</div> -->
 <!-- Modal -->
<!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Notification</h4>
      </div>
      <div class="modal-body">
          I understand that I need to have at least GHS100 on my MoMo account. I also understand that I need to wait for at least 8 days to receive help from others.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="create">Ok</button>
      </div>
    </div>
  </div>
</div>
  -->
<div id="activate_eproduct_choose" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Wants to Activae eProduct Plan?</h4>
      </div>
      
      <Form action="<?php echo BASE_URL?>member/eproducts/activate_eproduct_plan" method="POST">
        <div class="modal-body">
          <div class="alert alert-info">
            <strong>To activate the eProducts plan, user must required 150GHS into GHS-bPoints account Or 35USD into USDb-points account. Purchase More, Enjoy More!</strong> 
          </div>
            <label><strong> Activate Using:</strong></label>
            <select class="form-control" name="activate_mode" id="activate_mode">
                <option value="">Select Mode</option>
                <option value="using_ghs">150GHS</option>
                <option value="using_usd">35USD</options>
            </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
 
   
   
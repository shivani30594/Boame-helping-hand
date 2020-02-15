<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Settings</h3>
    <small>Manage Merchant-account setting from here. Admin can set merchant Id, Public key, Private key and secret key from here!</small>
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
<div>
    <div class="col-sm-6">
        <section class="panel panel-default">
        <header class="panel-heading font-bold">Settings</header>
        <div class="panel-body">
            <form role="form" action="<?php echo BASE_URL.'/admin/settings/update'?>" method="post" id="setting_form">
            <div class="form-group">
                <label>Default Subscription Plan</label>
                <select class="form-control" name="default_subscription_plan_id" id="default_subscription_plan_id">
                    <option value=''>-- Select Default Plan---</option>
                    <?php if(count($plan_details) > 0):?>
                        <?php foreach($plan_details as $plan):?>
                            <option value="<?php echo $plan->id?>" <?php echo $plan->id == $settting_details->default_subscription_plan_id ? 'selected' : 
                            ''?>><?php echo $plan->plan_duration?></option>
                        <?php endforeach;?>
                    <?php endif;?>
                </select>
            </div>
            <div class="form-group">
                <small><i>Auto-renewal plan will be set from here.Users who have auto-subscribed will be auto-reniewed with this plan by default.</i></small>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
                <label>Merchant ID</label>
                <input type="hidden" class="form-control" placeholder="Enter Merchant ID" name='setting_id' value="<?php echo isset($settting_details) ? $settting_details->id : ''?>">
                <input type="text" class="form-control" placeholder="Enter Merchant ID" name='merchant_id' value="<?php echo isset($settting_details) ? $settting_details->merchant_id : ''?>">
            </div>
            <div class="form-group">
                <label>Public Key</label>
                <input type="text" class="form-control" placeholder="Enter Merhcant Public Key" name='public_key'  value="<?php echo isset($settting_details) ? $settting_details->public_key : ''?>" >
            </div>
            <div class="form-group">
                <label>Private Key</label>
                <input type="text" class="form-control" placeholder="Enter Merhcant Private Key" name='private_key'  value="<?php echo isset($settting_details) ? $settting_details->private_key : ''?>">
            </div>
            <div class="form-group">
                <label>Secret Key</label>
                <input type="text" class="form-control" placeholder="Enter Merhcant Secret Key" name='secret_key'  value="<?php echo isset($settting_details) ? $settting_details->secret_key : ''?>">
            </div>
            <div class="form-group">
                <label>Exchange rate for GHS to USD</label>
                <input type="text" class="form-control" placeholder="Enter Merhcant Secret Key" name='ghs_to_usd'  value="<?php echo isset($settting_details) ? $settting_details->ghs_to_usd : ''?>">
            </div>
            <div class="form-group">
                <label>Exchange rate for USD to GHS</label>
                <input type="text" class="form-control" placeholder="Enter Merhcant Secret Key" name='usd_to_ghs'  value="<?php echo isset($settting_details) ? $settting_details->usd_to_ghs : ''?>">
            </div>
            <div class="form-group">
                <label>Callback URL(IPN URL)</label>
                <input type="text" class="form-control" placeholder="Enter IPN URL" name='ipn_url'  value="<?php echo isset($settting_details) ? $settting_details->ipn_url : ''?>">
            </div>
            <div class="form-group">
                <small><i>These information are used to connect Coinpayment API with Merchant.Make Sure that information is correct.</i></small>
            </div>
            <button type="submit" class="btn btn-sm btn-success">Submit</button>
            </form>
        </div>
        </section>
    </div>
</div>


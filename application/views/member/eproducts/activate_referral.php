<section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">eProduct Plan</h3>
    <small>150 Bpoints will be deducted from your account on activation of one account.To activate your friend's plan follow the steps!</small>
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
<?php if ($this->session->flashdata('warning')): ?>
    <div class="alert alert-warning">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <i class="fa fa-ok-sign"></i><?= $this->session->flashdata('warning'); ?>
    </div>
<?php endif; ?>
<div class="alert alert-info">
  <strong>To activate the eProducts plan, user must required 150GHS into GHS-bPoints account Or 35USD into USDb-points account. Purchase More, Enjoy More!</strong> 
</div>
<div class="row">
  <div class="col-sm-6">
      <form class="form-horizontal" data-validate="parsley" method="post" action="<?php echo BASE_URL;?>member/eproducts/active_plan_referral" id="activate_referal_plan">
        <section class="panel panel-default">
          <header class="panel-heading">
            <strong>Activate eProduct Plan</strong>
          </header>
          <div class="panel-body">                    
            <div class="form-group">
              <label class="col-sm-3 control-label">Referral Code</label>
              <div class="col-sm-9">
                <input type="text" class="form-control parsley-validated" id="referral_code" name="referral_code" data-type="text" data-required="true" placeholder="Referral Code">    
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label"> Activate Using:</label>
              <div class="col-sm-9">
                <select  class="form-control" name="activate_mode" id="activate_mode" required>
                  <option value="">Select Mode</option>
                  <option value="using_ghs">150GHS</option>
                  <option value="using_usd">35USD</options>
                </select>
            </div>
            </div>
          </div>
          <footer class="panel-footer text-right bg-light lter">
            <button type="submit" class="btn btn-success btn-s-xs">Activate Plan</button>
          </footer>
        </section>
      </form>
    </div>  
</div>  
<section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">Transfer Points</h3>
    <small>You can transfer any number of points to any user by entering referral code of user to whom you want. You can transfer only GHS to GHS and USD to USD bPoints. !!!</small>
  </div>
</section>
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
<?php if ($this->session->flashdata('warning')): ?>
    <div class="alert alert-warning">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <i class="fa fa-ok-sign"></i><?= $this->session->flashdata('warning'); ?>.
    </div>
<?php endif; ?>
<div class="form-group" style="display:none" id="referral_code_error">
  <div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <i class="fa fa-ok-sign"></i>Referral code doesn't exists. Please try again.
  </div>    
</div>
<div class="form-group" style="display:none" id="referral_code_error_another">
  <div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <i class="fa fa-ok-sign"></i>You are entering the referral code of your own. Please enter valid referral code of another user. 
  </div>    
</div>
<div class="row">
  <div class="col-sm-6">
      <form class="form-horizontal" data-validate="parsley" method="post" action="<?php echo BASE_URL;?>member/transfer/add" id="transfer_points_form">
        <section class="panel panel-default">
          <header class="panel-heading">
            <strong>Transfer Points</strong>
          </header>
          <div class="panel-body">                    
            <div class="form-group">
              <label class="col-sm-3 control-label">Referral Code</label>
              <div class="col-sm-9" id="pledge_title_div">
                <input type="text" class="form-control" name="referral_code" id="referral_code" placeholder="Referral Code">
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Type</label>
              <div class="col-sm-9" id="pledge_title_div">
                <select class="form-control" name="type" id="type" required>
                  <option value="">Select the type</option>
                  <option value="ghs_to_ghs">GHS to GHS</option>
                  <option value="usd_to_usd">USD to USD</option>
                </select>
                <small>* If you choose GHS to GHS option, bPoints can be only be transfer from GHS-bPoints to GHS-bPoints. Same for USD to USD. </small>
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Points</label>
              <div class="col-sm-9">
                <input type="number" class="form-control" name="points" id="points" placeholder="Points to be transferred">
              </div>
            </div>
          <footer class="panel-footer text-right bg-light lter">
            <button type="submit" class="btn btn-success btn-s-xs">Transfer</button>
          </footer>
        </section>
      </form>
    </div>  
</div>  
<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Purchased Point</h3>
    <small>To purchase the points follow the steps:</small>
  </div>
</section>
 <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-error">
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
<div class="row">
  <div class="col-sm-6">
      <form class="form-horizontal" data-validate="parsley" method="post" action="<?php echo BASE_URL;?>member/User_payment/submit_request" id="make_payment_form">
        <section class="panel panel-default">
          <header class="panel-heading">
            <strong>Make Purchased Request</strong>
          </header>
          <div class="panel-body">                    
            <div class="form-group">
              <label class="col-sm-3 control-label">Referral Code</label>
              <div class="col-sm-9">
                <input type="text" class="form-control parsley-validated" id="referral_code" name="referral_code" data-type="text" data-required="true" placeholder="Referral Code" disabled value="<?php echo isset($refferal_code) ? $refferal_code : ''?>">    
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Amount to be purchased</label>
              <div class="col-sm-9">
                  <input type="number" required class="form-control parsley-validated" min="1" id="amount_to_be_purchased" name="amount_to_be_purchased" placeholder="Amount to be purchased" value="">
              </div>
            </div>
            <div class="form-group text-center" id="amount_div" style="display:none">
              <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <i class="fa fa-ok-sign"></i>You are going to purchase <span id="amount_span"></span>Bpoints.
              </div>
            </div>
          </div>
          <footer class="panel-footer text-right bg-light lter">
            <button type="submit" class="btn btn-success btn-s-xs">Make Request</button>
          </footer>
        </section>
      </form>
    </div>  
</div>  
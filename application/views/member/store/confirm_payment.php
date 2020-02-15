<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Purchased Point</h3>
    <small>To confirm the payment, Fill up the necessary details and send to admin.</small>
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
      <form class="form-horizontal" data-validate="parsley" method="post" action="<?php echo BASE_URL;?>member/store/update" id="edit_profile_form">
        <section class="panel panel-default">
          <header class="panel-heading">
            <strong>Final Step for payment Confirmation</strong>
          </header>
          <div class="panel-body">                    
            <div class="form-group">
              <label class="col-sm-3 control-label">Transaction ID</label>
              <div class="col-sm-9">
                 <input type="hidden" class="form-control parsley-validated" id="purchased_id" name="purchased_id" value="<?php echo isset($purchased_id) ? $purchased_id : ''?>">    
                <input type="number" class="form-control parsley-validated" id="transaction_id" name="transaction_id" placeholder="Transaction ID" value="<?php echo isset($purchased_array->transaction_id) ? $purchased_array->transaction_id : ''?>">    
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Sent Amount:</label>
              <div class="col-sm-9">
                <input type="number" required class="form-control parsley-validated" id="sent_amount" name="sent_amount" placeholder="Sent Amount" value="<?php echo isset($purchased_array->purchased_points) ? $purchased_array->purchased_points : ''?>">
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Sender Name:</label>
              <div class="col-sm-9">
                <input type="text" required class="form-control parsley-validated" id="sender_name" name="sender_name" placeholder="Sender Name" value="<?php echo isset($purchased_array->sender_name) ? $purchased_array->sender_name : ''?>">
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Sender Number:</label>
              <div class="col-sm-9">
                <input type="phone" required class="form-control parsley-validated" id="sender_number" name="sender_number" placeholder="Sender Number" value="<?php echo isset($purchased_array->sender_number) ? $purchased_array->sender_number : ''?>">
              </div>
            </div>
            <div class="form-group text-center" id="amount_div" style="display:none">
              <p class="p-5 mb-2 bg-success text-white">Your are going to purchase GHS<span id="amount_span"></span>.</p>
            </div>
          </div>
          <footer class="panel-footer text-right bg-light lter">
            <button type="submit" class="btn btn-success btn-s-xs">Confirm</button>
          </footer>
        </section>
      </form>
    </div>  
</div>  
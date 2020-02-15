<section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">USD Withdrawal Requests</h3>
    <small>Manage withdrawal request from here. 3% trasnsactional charges will be deducted from the requested amount!!</small>
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
<div class="text-right">
  <a class="btn btn-primary" id="withdraw_request_a" data-toggle="modal" data-target="#myModal">Withdraw Request</a>
</div>
 <div class="table-responsive">
    <table class="table table-striped m-b-none" id="withdrawal_request">
      <thead>
        <tr>
            <th>Id</th>
            <th>Requested Amount</th>
            <th>Getting Amount</th>
            <th>Type</th>
            <th>Address</th>
            <th>Status</th>
            <th>Withdraw Date</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Withdrawal Request</h4>
      </div>
      <div class="modal-body">
      <p style="color:#442323; font-size:16px;font-weight:600">GHS-eWallet: <?php echo isset($total_ewallet) ? number_format((float)$total_ewallet, 2, '.', '')  : ''?></p>
        <p style="color:#442323; font-size:16px;font-weight:600">USD-eWallet: <?php echo isset($total_ewallet_usd) ? number_format((float)$total_ewallet_usd, 2, '.', '')  : ''?></p>
        <hr>
          <div class="form-group" style="display:none" id="getting_div">
            <div class="alert alert-warning">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <i class="fa fa-ok-sign"></i>After appling <?php echo $transaction_charges?>% transactional charges, you will be able to get <span id="getting_amount"></span>.
            </div>
          </div>
          <div class="form-group" style="display:none" id="minimal_error">
            <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <i class="fa fa-ok-sign"></i><span id="minimal_error_span">You have entered less than GHS20. Minimal withdrawal amount is GHS20.</span>
            </div>
          </div>
        <form method="POST" action="<?php echo BASE_URL?>member/withdraw/add" name="withdraw_form" id="withdraw_form">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Type:</label>
            <div class="radio-inline"> 
              <label> 
                <input type="radio" name="type" id="type_1" value="GHS" checked=""> GHS
              </label> 
            </div> 
            <div class="radio-inline"> 
              <label> 
                <input type="radio" name="type" id="type_2" value="USD"> USD
              </label> 
            </div> 
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Requested Amount:</label>
            <input type="hidden" name="timezone" id="timezone" value=''>
            <input type="number" class="form-control" id="requested_amount" name="requested_amount" required>
          </div>
          <div class="form-group" id="address_div" style="display:none">
            <label for="recipient-name" class="col-form-label">Bitcoin Ewallet Address:</label>
            <input type="text" class="form-control" id="address" name="address">
          </div>
          <button type="submit" class="btn btn-primary" id="create">Submit</button>
        </form>
      </div>
     <!--  <div class="modal-footer">
       <button type="button" class="btn btn-primary" id="create">Ok</button>
     </div> -->
    </div>
  </div>
</div>
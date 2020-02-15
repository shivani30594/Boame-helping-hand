<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Buy USDbPoints</h3>
    <small>You can buy USDbPoints from here. Also, listed the buy USDpoints history over here.:</small>
  </div>
</section>
<div class="row">
  <div class="col-sm-3 text-left">
    <h4><strong>USDbPoints : <?php echo isset($usdbpoints) ? $usdbpoints : '0'?> </strong></h4>
  </div>
  <div class="col-sm-offset-6 text-right" style="margin-right:10px">
  <a href="<?php echo BASE_URL?>buy_usd_request" class="btn btn-primary"><i class="fa fa-plus"></i> Add USDbPoints</a>
  </div>
</div>
<div class="table-responsive">
  <table class="table table-striped m-b-none" id="purchased_history">
    <thead>
      <tr>
        <th>Transaction Id</th>
        <th>Address</th>
        <th>Order Amount</th>
        <th>Status</th>
        <th>Date</th>
        <th>Last Modified</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
  

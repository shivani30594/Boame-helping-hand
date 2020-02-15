<section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">Exchange History</h3>
    <small>From here, you can the exchange transaction history</small>
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
  <a href="<?php echo BASE_URL;?>exchange" class="btn btn-primary">Exchange eWallet</a>
</div>
 <div class="table-responsive">
    <table class="table table-striped m-b-none" id="exchange_history">
      <thead>
        <tr>
            <th>Id</th>
            <th>Exchanged Amount</th>
            <th>Getting Amount</th>
            <th>Exchange From</th>
            <th>Exchange To</th>
            <th>Rate Applied</th>
            <th>Exchanged Date</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

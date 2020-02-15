<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Buy USDbPoint Requests</h3>
    <small>Manage USDbPoints request from here!!</small>
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

 <div class="table-responsive">
    <table class="table table-striped m-b-none" id="withdrawal_request">
      <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Buy Amount</th>
            <th>Address</th>
            <th>Transaction ID</th>
            <th>Status</th>
            <th>Order Date</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

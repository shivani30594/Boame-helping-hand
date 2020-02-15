<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Subscription Plan</h3>
    <small>Manage subscription plans from here!!</small>
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
<div class="text-right">
  <a href="<?php echo BASE_URL?>admin/subscription/add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Plan</a>
</div>
 <div class="table-responsive">
    <table class="table table-striped m-b-none" id="subscription">
      <thead>
        <tr>
            <th>Plan ID</th>
            <th>Plan Name</th>
            <th>Plan Description</th>
            <th>Plan duration</th>
            <th>Plan Price</th>
            <th>Currency Accepted</th>
            <th>Plan Created</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

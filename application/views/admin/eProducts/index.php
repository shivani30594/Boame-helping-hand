  <section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">eProducts</h3>
    <small>Manage eProducts from here!!</small>
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
  <a href="<?php echo BASE_URL?>admin/Eproducts/edit" class="btn btn-primary">Add Product</a>
</div>
 <div class="table-responsive">
    <table class="table table-striped m-b-none" id="eProducts">
      <thead>
        <tr>
            <th>Product Name</th>
            <th>Product Type</th>
            <th>Download Link</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

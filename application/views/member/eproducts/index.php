  <section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">eProducts</h3>
    <small>Your eProducts plan is activated!! Here is a list of eProducts.</small>
  </div>
</section>
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <i class="fa fa-ok-sign"></i><?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

 <div class="table-responsive">
    <table class="table table-striped m-b-none" id="eproducts">
      <thead>
        <tr>
            <th>Product Name</th>
            <th>Product Type</th>
            <th>Download Link</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Promotional Tools</h3>
    <small>Manage Promotional Tools From Here!!</small>
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
  <a href="<?php echo BASE_URL?>admin/resource/edit" class="btn btn-primary">Add Resource</a>
</div> 
 <div class="table-responsive">
    <table class="table table-striped m-b-none" id="news">
      <thead>
        <tr>
            <th>Id</th>
            <th>Type</th>
            <th>Title</th>
            <th>Docuement</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
  
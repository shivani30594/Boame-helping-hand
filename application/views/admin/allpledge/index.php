  <section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">Pledge Listing</h3>
    <small>Here is the fresh pledge listing. Admin can manually declare the use as paid user!</small>
  </div>
</section>
<!-- <div class="text-left">
  <div style="padding:2px"><span class="label bg-danger">Timeout</span> <small>: 24 hours is completd still don't pay to the matching user.</small></div>
</div> -->
  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
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
 <div class="table-responsive">
    <table class="table table-striped m-b-none" id="pledge_queue">
      <thead>
        <tr>
            <th>ID</th>
            <th>Name </th>
            <th>Pledge Type</th>
            <th>Pledge Description</th>
            <th>Pledge Date</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
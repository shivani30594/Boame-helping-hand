  <section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">Joining History</h3>
    <small>This report contains the joining memmber history. How many user referres to you till Now.</small>
  </div>
</section>
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
    <table class="table table-striped m-b-none" id="joining_tabel">
      <thead>
        <tr>
            <th>ID</th>
            <th>Profile</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Status</th>
            <th>Date of Joining</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
<section class="row m-b-md">
<div class="col-sm-12">
  <h3 class="m-b-xs text-black">GHS bPoints Transfer History</h3>
  <small>Admin can see GHS bPoints transfer history from here.</small>
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
 <div class="bs-example">
     <table id="credited_points" class="table table-striped table-hover">
        <thead>
           <tr>
              <th>Id</th>
              <th>History Details</th>
              <th>Accounting Type</th>
              <th>Date</th>
           </tr>
        </thead>
     </table>
  </div> <!-- <div class="bs-example"> -->

<section class="row m-b-md">
<div class="col-sm-12">
  <h3 class="m-b-xs text-black">Transfer History</h3>
  <small>Manage transfer history from here. See credited and debited points details by switching. Enjoy!!</small>
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
<div class="text-right" >
  <a href="<?php echo BASE_URL?>member/transfer/add_view" class="btn btn-primary" style="margin-bottom:10px">Transfer Points</a>
</div>
 <div class="bs-example">
  <div>
        <ul class="nav nav-tabs">
            <li class="active"><a class="nav-link" data-toggle="tab" href="#sectionA">Credited Points</a></li>
            <li><a href="#sectionB" data-toggle="tab">Debited Points</a></li>
        </ul>
    </div>
     <div class="tab-content">
        <div id="sectionA" class="tab-pane fade in active table-responsive">
           <table id="credited_points" class="table table-striped table-hover">
              <thead>
                 <tr>
                    <th>Id</th>
                    <th>Received From</th>
                    <th>Points</th>
                    <th>Type</th>
                    <th>Date</th>
                 </tr>
              </thead>
           </table>
        </div>  <!--sectionA-->
        <div id="sectionB" class="tab-pane fade table-responsive">
           <table id="debited_points" class="table table-striped table-hover">
              <thead>
                 <tr>
                    <th>Id</th>
                    <th>Send To</th>
                    <th>Points</th>
                    <th>Type</th>
                    <th>Date</th>
                 </tr>
              </thead>
           </table>
        </div>  <!--sectionB-->
     </div> <!-- <div class="tab-content"> -->
  </div> <!-- <div class="bs-example"> -->

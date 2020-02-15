  <section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">Point History</h3>
    <small>Here is the history of commission point getting from diffrent user.</small>
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
    <table class="table table-striped m-b-none" id="Bonus_point_table">
      <thead>
        <tr>
            <th>ID</th>
            <th>Earned From</th>
            <th>Type</th>
            <th>Points earned</th>
            <th>Date</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
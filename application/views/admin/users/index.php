  <section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Users</h3>
    <small>Manage user from here!!</small>
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
    <table class="table table-striped m-b-none" id="posts">
      <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>MTN Number</th>
            <th>MTN Name</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
<div class="modal fade open-AddPointsDialog" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?php echo BASE_URL?>admin/user/add_points" method="POST">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add bPoints</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Points to added:</label>
            <input type="text" class="form-control" id="points_added" name="points_added">
             <input type="hidden" class="form-control" id="userid" name="userid" class="userid">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
      </form>
    </div>
  </div>
</div>
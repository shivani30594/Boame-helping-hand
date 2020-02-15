<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Edit User</h3>
    <small>Add you MTN Account Name and Number to do the transaction ahead!!</small>
  </div>
</section>
 <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-error">
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
<div class="row">
  <div class="col-sm-6">
      <form class="form-horizontal" data-validate="parsley" method="post" action="<?php echo BASE_URL;?>admin/user/edit_profile" id="edit_profile_form">
        <input type="hidden" class="form-control parsley-validated" name="user_id" value="<?php echo $user_details->id;?>">
        <section class="panel panel-default">
          <header class="panel-heading">
            <strong>Edit User Details</strong>
          </header>
          <div class="panel-body">                    
            <div class="form-group">
              <label class="col-sm-3 control-label">First Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control parsley-validated" name="first_name" data-type="text" data-required="true" placeholder="First Name" value="<?php echo isset($user_details) ?  $user_details->first_name : '' ?>">    
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Last Name</label>
              <div class="col-sm-9">
                <input type="text" data-type="text" class="form-control parsley-validated" name="last_name" placeholder="Last Name" value="<?php echo isset($user_details) ?  $user_details->last_name : '' ?>">
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Email</label>
              <div class="col-sm-9">
                <input type="text" data-type="email" class="form-control parsley-validated" name="email" placeholder="EmailId" value="<?php echo isset($user_details) ?  $user_details->email : '' ?>">
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Gender</label>
              <div class="col-sm-9">
                <div class="radio">
                  <label>
                    <input type="radio" name="gender" id="male" value="male" <?php echo $user_details->gender == 'male' ? 'checked' : ''?>>
                    Male
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="gender" id="female" value="female" <?php echo $user_details->gender == 'female' ? 'checked' : ''?>>
                    Female
                  </label>
                </div>
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">MTN Account Number</label>
              <div class="col-sm-9">
                <input type="text" data-type="phone" <?php echo isset($user_details->mtn_mobile_number) ? "disabled" : '' ?> class="form-control parsley-validated" name="mtn_mobile_number" placeholder="MTN Account Number" value="<?php echo isset($user_details) ?  $this->data['user_details']->mtn_mobile_number : '' ?>">
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">MTN Account Name</label>
              <div class="col-sm-9">
                <input type="text" data-type="text" class="form-control parsley-validated" name="mtn_mobile_name" placeholder="MTN Account Name" value="<?php echo isset($user_details) ?  $this->data['user_details']->mtn_mobile_name : '' ?>">
              </div>
            </div>
          </div>
          <footer class="panel-footer text-right bg-light lter">
            <button type="submit" class="btn btn-success btn-s-xs">Edit</button>
          </footer>
        </section>
      </form>
    </div>  
</div>  
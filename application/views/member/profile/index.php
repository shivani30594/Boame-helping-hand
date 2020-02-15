<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Profile</h3>
    <small>Add you MTN Account Name and Number to do the transaction ahead!!</small>
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
<div class="row">
  <div class="col-sm-6">
    <section class="panel panel-default pos-rlt clearfix">
      <header class="panel-heading">
        <ul class="nav nav-pills pull-right">
          <li>
            <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
          </li>
        </ul>
        Edit Personal Information
      </header>   
      <div class="panel-body clearfix">
        <div class="dropdown m-r">
          <form class="form-horizontal" data-validate="parsley" method="post" action="<?php echo BASE_URL;?>member/profile/edit_profile" id="edit_profile_form">
           <div class="panel-body">                    
              <div class="form-group">
                <label class="col-sm-3 control-label">First Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control parsley-validated" name="first_name" data-type="text" data-required="true" placeholder="First Name" value="<?php echo isset($this->data['member_details']) ?  $this->data['member_details']->first_name : '' ?>">    
                </div>
              </div>
              <div class="line line-dashed b-b line-lg pull-in"></div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Last Name</label>
                <div class="col-sm-9">
                  <input type="text" data-type="text" class="form-control parsley-validated" name="last_name" placeholder="Last Name" value="<?php echo isset($this->data['member_details']) ?  $this->data['member_details']->last_name : '' ?>">
                </div>
              </div>
              <div class="line line-dashed b-b line-lg pull-in"></div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control parsley-validated" name="email" placeholder="EmailId" value="<?php echo isset($this->data['member_details']) ?  $this->data['member_details']->email : '' ?>">
                </div>
              </div>
              <div class="line line-dashed b-b line-lg pull-in"></div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Gender</label>
                <div class="col-sm-9">
                  <div class="radio">
                    <label>
                      <input type="radio" name="gender" id="male" value="male" <?php echo $this->data['member_details']->gender == 'male' ? 'checked' : ''?>>
                      Male
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gender" id="female" value="female" <?php echo $this->data['member_details']->gender == 'female' ? 'checked' : ''?>>
                      Female
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <footer class="panel-footer text-right bg-light lter">
            <button type="submit" class="btn btn-success btn-s-xs">Edit Information</button>
          </footer>
          </form>
        </div>
      </div>
    </section>
  </div>  
</div>  
<div class="row">
  <div class="col-sm-6">
    <section class="panel panel-default pos-rlt clearfix">
      <header class="panel-heading">
        <ul class="nav nav-pills pull-right">
          <li>
            <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
          </li>
        </ul>
        Edit MTN Information
      </header>   
      <div class="panel-body clearfix">
        <div class="dropdown m-r">
          <form class="form-horizontal" data-validate="parsley" method="post" action="<?php echo BASE_URL;?>member/profile/edit_mtn_detail" id="edit_mtn_form">
              <div class="alert alert-danger" style="display:none" id="alert_div">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <i class="fa fa-ban-circle"></i><strong>Oh sorry! </strong><span id="error_span"></span>
              </div>
              <div class="alert alert-success" style="display:none" id="success_div">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <i class="fa fa-ban-circle"></i><strong>Well done!! </strong><span id="success_span"></span>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-9">
                  <label for="" id="phone_error_label" style="display:none;color:red">Please enter the valid phone number</label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">MTN Account Number</label>
                <div class="col-sm-9">
                  <input type="tel" required data-type="phone" class="form-control parsley-validated" id="phone_number" name="mtn_mobile_number" placeholder="MTN Account Number" value="<?php echo isset($this->data['member_details']) ?  '+'.$this->data['member_details']->mtn_mobile_number : '' ?>">
                </div>
              </div>
              <div class="form-group" id="error_div" style="display:none;">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-9">
                  <label for="" id="verification_error_label" style="display:none; color:red">Please try again later. Your MTN number is not verified.</label>
                  <label for="" id="verification_success_label" style="display:none; color:#179877">Your MTN number is verified.</label>
                  <label for="" id="verification_label" style="display:none;color:red">Please enter the valid verification code</label>
                </div>
              </div>
              <div class="form-group" id="verify_code" style="display:none">
                <label class="col-sm-3 control-label">Enter Your verification code:</label>
                <div class="col-sm-3">
                  <input type="text" data-type="phone" required class="form-control parsley-validated" id="verification_code" name="verification_code" placeholder="Verification code">
                </div>
              </div>
              <div class="line line-dashed b-b line-lg pull-in"></div>
              <div class="form-group" >
                <label class="col-sm-3 control-label">MTN Account Name</label>
                <div class="col-sm-9">
                  <input type="text" data-type="text" class="form-control parsley-validated" name="mtn_mobile_name" placeholder="MTN Account Name" value="<?php echo isset($this->data['member_details']) ?  $this->data['member_details']->mtn_mobile_name : '' ?>">
                </div>
              </div>
            </div>
            <footer class="panel-footer text-right bg-light lter">
              <button type="submit" class="btn btn-success btn-s-xs">Edit MTN Information</button>
            </footer>
          </form>
        </div>
      </div>
    </section>
  </div>  
</div> 
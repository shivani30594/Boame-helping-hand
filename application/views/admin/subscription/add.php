<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black"><?php echo isset($edit) ? 'Edit' : 'Add'?> Subscription Plan</h3>
    <small><?php echo isset($edit) ? 'Edit' : 'Add'?> subscription plans from here!!</small>
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
<div class="row">
  <div class="col-sm-6">
      <form class="form-horizontal" data-validate="parsley" method="post" enctype="multipart/form-data" action="<?php echo BASE_URL;?>admin/subscription/edit" id="edit_plan_form">
        <input type="hidden" class="form-control parsley-validated" name="plan_id" value="<?php echo isset($plan_details) ?  $plan_details->id : '';?>">
        <section class="panel panel-default">
          <header class="panel-heading">
            <strong><?php echo isset($edit) ? 'Edit Plan Details' : 'Add Plan Details'?></strong>
          </header>
          <div class="panel-body">                    
            <div class="form-group">
              <label class="col-sm-3 control-label">Plan Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control parsley-validated" name="plan_name" data-type="text" data-required="true" placeholder="Plan Name" value="<?php echo isset($plan_details) ?  $plan_details->plan_name : '' ?>">    
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Plan Price</label>
              <div class="col-sm-9">
                <input type="number" class="form-control parsley-validated" name="plan_price" data-type="text" data-required="true" placeholder="Plan Price" value="<?php echo isset($plan_details) ?  $plan_details->plan_price : '' ?>">    
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Plan Currency</label>
              <div class="col-sm-9">
                <select class="form-control" name="plan_price_currency" id="plan_price_currency">
                    <option value=''>--Select Currency--</option>
                    <option value='USD' <?php echo (isset($plan_details) AND $plan_details->plan_price_currency == 'USD' )? 'selected' : ''?>>USD</option>
                    <option value='GHS'  <?php echo (isset($plan_details) AND $plan_details->plan_price_currency == 'GHS')? 'selected' : ''?>>GHS</option>
                </select>
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div><div class="form-group">
              <label class="col-sm-3 control-label">Plan Desciption</label>
              <div class="col-sm-9">
                <textarea rows="10" class="form-control parsley-validated" name="plan_description" data-type="text" data-required="true" placeholder="Plan Descirption"><?php echo isset($plan_details)?$plan_details->plan_description : '' ?></textarea>
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div><div class="form-group">
              <label class="col-sm-3 control-label">Plan Duration</label>
              <div class="col-sm-9">
                <input type="text" class="form-control parsley-validated" name="plan_duration" data-type="text" data-required="true" placeholder="Plan Duration" value="<?php echo isset($plan_details) ?  $plan_details->plan_duration : '' ?>">    
              </div>
            </div>
          <footer class="panel-footer text-right bg-light lter">
            <button type="submit" name="submitBtn" id="submitBtn" class="btn btn-success btn-s-xs"><?php echo isset($edit) ? 'Edit' : 'Add'?></button>
          </footer>  
        </section>
      </form>
    </div>  
</div>  

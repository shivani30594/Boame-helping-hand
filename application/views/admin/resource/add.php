<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Add New Resource</h3>
    <small>Admin can manage resources like banner, pdf, ppt and video gallery from here!</small>
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
      <form class="form-horizontal" data-validate="parsley" method="post" enctype="multipart/form-data" action="<?php echo BASE_URL;?>admin/resource/<?php echo isset($edit) ? 'edit_resource' : 'add_resource'?>" id="edit_resource_form">
        <input type="hidden" class="form-control parsley-validated" name="resource_id" value="<?php echo isset($resource_details) ?  $resource_details->id : '';?>">
        <input type="hidden" class="form-control parsley-validated" name="resource_document_path" value="<?php echo isset($resource_details) ? $resource_details->document_path : '' ;?>">
        <section class="panel panel-default">
          <header class="panel-heading">
            <strong><?php echo isset($edit) ? 'Edit Resource' : 'Add Resource'?></strong>
          </header>
          <div class="panel-body">                    
            <div class="form-group">
              <label class="col-sm-3 control-label">Resource Title:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control parsley-validated" name="document_title" data-type="text" data-required="true" placeholder="Short Description" value="<?php echo isset($resource_details) ?  $resource_details->document_title : '' ?>">    
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Resource Type:</label>
              <div class="col-sm-9">
                <select id="resource_type" name="resource_type" required class="form-control">
                    <option value=''></option>
                    <option value='html' <?php echo isset($resource_details) && $resource_details->type == 'html' ? 'selected' : '' ?>>HTML Banner</option>
                    <option value='banner' <?php echo isset($resource_details) && $resource_details->type == 'banner' ? 'selected' : '' ?>>Banner</option>
                    <option value='video' <?php echo isset($resource_details) && $resource_details->type == 'video' ? 'selected' : '' ?>>Video Gallery</option>
                    <option value='ppt' <?php echo isset($resource_details) && $resource_details->type == 'ppt' ? 'selected' : '' ?>>PPT</option>
                    <option value='pdf' <?php echo isset($resource_details) && $resource_details->type == 'pdf' ? 'selected' : '' ?>>PDF</option>
                </select>
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Document</label>
              <div class="col-sm-9">
                <input type="file" class="form-control" id="document" name="document" <?php echo isset($resource_details) && $resource_details->document_path != '' ? '' : 'required'?>>    
                <span  class="error" id="file_error_span" style="display:none">Please choose valid file based on resource type.</span>
                <?php if (isset($edit)) : ?>
                  <div>
                  <?php if($resource_details->type == 'banner'):?>
                      <img src="<?php echo ADMIN_RESOURCE.$resource_details->type.'/'.$resource_details->document_path?>" height="100px" width="100px" />
                  <?php elseif($resource_details->type == 'pdf'):?>
                      <a href="<?php echo  ADMIN_RESOURCE.$resource_details->type.'/'.$resource_details->document_path?>" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i><br><?php echo isset($resource_details) ? $resource_details->document_path : '' ?></a>
                  <?php elseif($resource_details->type == 'ppt'):?>
                      <a href="<?php echo  ADMIN_RESOURCE.$resource_details->type.'/'.$resource_details->document_path?>" target="_blank"><i class="fa fa-file-powerpoint-o fa-5x"></i><br><?php echo isset($resource_details) ? $resource_details->document_path : '' ?></a>
                  <?php elseif($resource_details->type == 'video'):?>
                      <video width="240" height="240" controls><source src="<?php echo ADMIN_RESOURCE.$resource_details->type.'/'.$resource_details->document_path?>" type="video/mp4">Your browser does not support the video tag.</video>
                  <?php elseif($resource_details->type == 'html'):?>
                      <iframe src="<?php echo ADMIN_RESOURCE.$resource_details->type.'/'.$resource_details->document_path?>" height="200" width="300"></iframe>
                  <?php endif;?>
                  </div>
                <?php endif;?>
              </div>
            </div>
          </div>
          <footer class="panel-footer text-right bg-light lter">
            <button type="submit" name="submitBtn" id="submitBtn" class="btn btn-success btn-s-xs"><?php echo isset($edit) ? 'Edit' : 'Add'?></button>
          </footer>
        </section>
      </form>
    </div>  
</div>  
<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black"><?php echo isset($edit) ? 'Edit Testimonial' : 'Add Testimonial'?></h3>
    <small>Manage Testimonial details from here!</small>
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
<div class="alert alert-danger" id="ckeditor_required" style="display:none">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <i class="fa fa-ok-sign"></i> Please enter the valid testimonial message.
</div>
<div class="row">
  <div class="col-sm-12">
      <form class="form-horizontal" data-validate="parsley" method="post" enctype="multipart/form-data" action="<?php echo BASE_URL;?>member/testimonial/<?php echo isset($edit) ? 'edit_testimonial' : 'add_testimonial'?>" id="edit_testimonial_form">
        <input type="hidden" class="form-control parsley-validated" name="news_id" value="<?php echo isset($testimonial) ?  $testimonial->id : '';?>">
        <input type="hidden" class="form-control parsley-validated" name="news_image_name" value="<?php echo isset($testimonial) ? $testimonial->image : '' ;?>">
        <section class="panel panel-default">
          <header class="panel-heading">
            <strong><?php echo isset($edit) ? 'Edit Testimonial' : 'Add Testimonial'?></strong>
          </header>
          <div class="panel-body">                    
            <div class="form-group">
              <label class="col-sm-3 control-label">Full Name</label>
              <div class="col-sm-9">
                <input type="text" required class="form-control parsley-validated" name="full_name" data-type="text" data-required="true" placeholder="Full Name" value="<?php echo isset($testimonial) ?  $testimonial->full_name : '' ?>">    
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Message</label>
              <div class="col-sm-9">
                  <textarea rows="20" cols="100" class="ckeditor" id="message" name="message"><?php echo isset($testimonial) && $testimonial->message != '' ? htmlspecialchars($testimonial->message) : '' ?></textarea>
                  <script type="text/javascript" src="<?php echo ADMIN_JS?>/ckeditor/ckeditor.js"></script>
                  <script type="text/javascript" src="<?php echo ADMIN_JS?>ckeditor/ckfinder.js"></script>
                  <script type="text/javascript">
                  var editor = CKEDITOR.replace( 'description', {
                      filebrowserBrowseUrl : '../../assets/js/ckfinder/ckfinder.html',
                      filebrowserImageBrowseUrl : '../../assets/js/ckfinder/ckfinder.html?type=Images',
                      filebrowserFlashBrowseUrl : '../../assets/js/ckfinder/ckfinder.html?type=Flash',
                      filebrowserUploadUrl : '../../assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                      filebrowserImageUploadUrl : '../../assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                      filebrowserFlashUploadUrl : '../../assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                  });
                  /*CKFinder.setupCKEditor( editor, '../' );*/
                  </script>                                   
                <!-- <textarea rows="15" class="form-control parsley-validated" name="description" placeholder="Description" ><?php echo isset($testimonial) ?  $testimonial->message : '' ?></textarea> -->
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Image</label>
              <div class="col-sm-9">
                <?php if (isset($edit)) : ?>
                  <img src="<?php echo ADMIN_TESTIMONIALS. $testimonial->image ?>" alt="" class="img-details" height="300px" width="300px">
                <?php endif;?>
                <input type="file" class="form-control" name="image" <?php echo isset($testimonial->image) ? '' : 'required' ?>>    
              </div>
            </div>
          </div>
          <footer class="panel-footer text-right bg-light lter">
            <button type="submit" name="submitBtn" id="submitBtn" class="btn btn-success btn-s-xs"><?php echo isset($edit) ? 'Edit' : 'Add'?></button>
          </footer>
        </section>
      </form>
      <script>
    </script>
    </div>  
</div>  
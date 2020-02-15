<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black"><?php echo isset($edit) ? 'Edit News' : 'Add News'?></h3>
    <small>Add news from here and display in the mobile application !</small>
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
      <i class="fa fa-ok-sign"></i> Please enter the valid News description.
</div>
<div class="row">
  <div class="col-sm-12">
      <form class="form-horizontal" data-validate="parsley" method="post" enctype="multipart/form-data" action="<?php echo BASE_URL;?>admin/news/<?php echo isset($edit) ? 'edit_news' : 'add_news'?>" id="edit_news_form">
        <input type="hidden" class="form-control parsley-validated" name="testimonial_id" value="<?php echo isset($news_details) ?  $news_details->id : '';?>">
        <input type="hidden" class="form-control parsley-validated" name="news_image_name" value="<?php echo isset($news_details) ? $news_details->image : '' ;?>">
        <section class="panel panel-default">
          <header class="panel-heading">
            <strong><?php echo isset($edit) ? 'Edit News' : 'Add News'?></strong>
          </header>
          <div class="panel-body">                    
            <div class="form-group">
              <label class="col-sm-3 control-label">Title</label>
              <div class="col-sm-9">
                <input type="text" class="form-control parsley-validated" name="title" data-type="text" data-required="true" placeholder="News Title" value="<?php echo isset($news_details) ?  $news_details->title : '' ?>">    
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Description</label>
              <div class="col-sm-9">
                  <textarea rows="20" cols="100" class="ckeditor" id="description" name="description"><?php echo isset($news_details) && $news_details->description != '' ? htmlspecialchars($news_details->description) : '' ?></textarea>
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
                <!-- <textarea rows="15" class="form-control parsley-validated" name="description" placeholder="Description" ><?php echo isset($news_details) ?  $news_details->description : '' ?></textarea> -->
              </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Image</label>
              <div class="col-sm-9">
                <?php if (isset($edit)) : ?>
                  <img src="<?php echo ADMIN_NEWS. $news_details->image ?>" alt="" class="img-details" height="300px" width="300px">
                <?php endif;?>
                <input type="file" class="form-control" name="image" <?php echo isset($news_details->image) ? '' : 'required' ?>>    
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
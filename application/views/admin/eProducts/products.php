<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black"><?php echo isset($edit) ? 'Edit Product' : 'Add Product'?></h3>
    <small>Add eProducts from here</small>
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
  <div class="col-sm-12">
      <form class="form-horizontal" data-validate="parsley" method="post" action="<?php echo BASE_URL;?>admin/Eproducts/<?php echo isset($edit) ? 'edit_product' : 'add_product'?>" id="edit_product_form">
        <input type="hidden" class="form-control parsley-validated" name="product_id" value="<?php echo isset($product_details) ?  $product_details->id : '';?>">
        <section class="panel panel-default">
          <header class="panel-heading">
            <strong><?php echo isset($edit) ? 'Edit Product' : 'Add Product'?></strong>
          </header>
          <div class="panel-body">                    
            <div class="form-group">
              <label class="col-sm-3 control-label">Product Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control parsley-validated" name="product_name" data-type="text" data-required="true" placeholder="Product Name" value="<?php echo isset($product_details) ?  $product_details->product_name : '' ?>">    
              </div>
            </div>
           
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Product Type</label>
              <div class="col-sm-9">
                  <select name="product_type" class="form-control parsley-validated">
                      <option value="eBooks" <?php echo isset($product_details) && $product_details->product_type == "eBooks"  ? 'selected' : '' ?>>eBooks</option>
                      <option value="Software" <?php echo isset($product_details) && $product_details->product_type == "Software"  ? 'selected' : '' ?>>Software</option>
                      <option value="Videos" <?php echo isset($product_details) && $product_details->product_type == "Videos"  ? 'selected' : '' ?>>Videos</option>
                      <option value="Audio" <?php echo isset($product_details) && $product_details->product_type == "Audio"  ? 'selected' : '' ?>>Audio</option>
                      <option value="Graphics" <?php echo isset($product_details) && $product_details->product_type == "Graphics"  ? 'selected' : '' ?>>Graphics</option>
                      <option value="Templates" <?php echo isset($product_details) && $product_details->product_type == "Templates"  ? 'selected' : '' ?>>Templates</option>
                  </select>
              </div>
            </div>
            
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Download Link</label>
              <div class="col-sm-9">
                <input type="text" class="form-control parsley-validated" name="download_link" data-type="text" data-required="true" placeholder="Download Link" value="<?php echo isset($product_details) ?  $product_details->download_link : '' ?>">    
              </div>
            </div>
          </div>
          <footer class="panel-footer text-right bg-light lter">
            <button type="submit" class="btn btn-success btn-s-xs"><?php echo isset($edit) ? 'Edit' : 'Add'?></button>
          </footer>
        </section>
      </form>
    </div>  
</div>  
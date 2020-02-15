<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Payment Instructions</h3>
    <small>You have to transfer money with following payment instructions:</small>
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
<div class="text-left">
  <a href="<?php echo BASE_URL?>purchased" class="btn btn-primary" style="margin-bottom:10px"><i class="fa fa-arrow-left"></i>  Back</a>
</div>
<div class="row">
  <div class="col-sm-12">
        <section class="panel panel-default" style="-webkit-box-shadow: 10px 13px 70px -10px rgba(0,0,0,0.75);
-moz-box-shadow: 10px 13px 70px -10px rgba(0,0,0,0.75);
box-shadow: 10px 13px 70px -10px rgba(0,0,0,0.75);">
          <header class="panel-heading">
            <strong>Payment Instructions</strong>
          </header>
          <div class="panel-body">                    
		  	<?php echo $instruction?>
		  </div>
        </section>
	</div>
</div>
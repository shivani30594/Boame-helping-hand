<section class="row m-b-md">
	<div class="col-sm-6">
	  <h3 class="m-b-xs text-black">User Tree</h3>
	  <small>Hello <b><?php echo $this->session->userdata("name") ?></b>, From here you can see the list of users who referred to you. Enjoy!!</small>
	</div>
</section>
<?php if ($count == 0):?>
<div class="alert alert-info alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<h4><i class="fa fa-bell-alt"></i>Warning!</h4>
	<p>No members are referring to you till now. Share more! Earn More!</p>
</div>
<?php endif;?>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="tree" style="overflow:scroll;padding:10px">
			<?php print_r($tree);?>
		</div>
	</div>
</div>

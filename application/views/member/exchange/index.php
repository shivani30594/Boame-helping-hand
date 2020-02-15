<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Exchange eWallet</h3>
    <small>You can exchange the eWallet from one another. For that, system will take the additional charge !</small>
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
    <div class="col-lg-2 text-left">
        <span class="label bg-info"  id="btn-label">GHS-eWallet: <?php echo number_format((float)$userSecondaryArray->ewallet, 2, '.', '')?></span>
    </div>
    <div class="col-lg-2 text-right">
        <span class="label bg-info"  id="btn-label">USD-eWallet: <?php echo number_format((float)$userSecondaryArray->ewallet_usd, 2, '.', '')?></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <section class="panel panel-default">
            <div class="panel-body">
                <div class="clearfix text-center m-t">
                    <div class="inline">
                        <div class="" style="width: 134px; height: 134px; line-height: 134px;">
                            <div class="thumb-lg">
                                <img src="<?php echo ADMIN_IMAGES?>ewallets-logo.png" class="img-circle" alt="">
                            </div>
                        </div>
                    </div>                      
                </div>
            </div>
            <footer class="panel-footer bg-warning text-center">
                <form name="form1">
                    <div class="form-group">
                        <label for="email">Amount:</label>
                        <input type="number" class="form-control" id="amount" required>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label for="email">Exchange From:</label>
                        <select class="form-control" name="exchange_from" id="exchange_from">
                            <option>Select Exchange From</option>
                            <option value="ghs">GHS</option>
                            <option value="usd">USD</option>
                        </select>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <button type="submit" id="exchange_button" class="btn btn-info">Exchange</button>
                    </div>
                </form>
            </footer>
        </section>
    </div>

</div>
 
   
   
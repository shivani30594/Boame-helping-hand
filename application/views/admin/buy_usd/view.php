<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Address Details</h3>
    <small>Here we show the address details for the transaction!</small>
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
<div class="row" id="address_row"> 
    <div class="col-md-12" id="address_details">
        <div class="row" >
            <img class="img-responsive col-sm-2" src="<?php echo isset($address_detail) ? $address_detail->qrcode_url : ''?>" id="qrcode_img" alt="Card Image" style="width:20% !important; margin: 0 auto;">
            <div class="col-sm-8">
                <div class="card-body">
                    <p class="card-text" style="margin: 1rem;font-weight:400">Send <strong><span id="amount_span" ><?php echo isset($address_detail) ? $address_detail->amount : ''?></span> BTC </strong></p>
                    <div class="alert alert-info" style="margin-bottom:0"><p class="card-text" style="margin: 1rem;font-weight:400"><span id="address_span"><?php echo isset($address_detail) ? $address_detail->address : ''?></span></p></div>
                    <p class="card-text" style="margin:0 0 0 1rem;font-weight:400"><span class="card-text">Simply scan QR code with your mobile device or copy one in the input box</span></p>
                    <p class="card-text" ><a style="color:#2a6496;margin: 1rem;font-weight:400" id="status_url_span" target="blank" href=" <?php echo isset($address_detail) ? $address_detail->status_url : ''?>">https://www.coinpayments.net/index.php?cmd=status&id=CPCG6GEESLAWUYLWHMENGGFYF5&key=64ae6c508a198fb0c78d480cdd12e808</a></p>
                </div>
            </div>
        </div>
    </div>
</div>  

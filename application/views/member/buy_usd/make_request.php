<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Buy USDbPoint</h3>
    <small>To buy the USDBpoints for the fixed amount of 35USD follow the steps:</small>
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
        <div class="card" style="box-shadow:0 9px 23px rgba(0, 0, 0, 0.09), 0 5px 5px rgba(0, 0, 0, 0.06) !important; background:white; border-radius:0.4167rem">
            <div class="card-body" style="padding:20px">
                <p class="card-text">
                <div class="panel-body" style="background:white">                    
                <p>You can buy any number of USDBPoints from the here. </p>
                <p> 1. Enter the amount you want to purchase. Click on the "Get Address" button. </p>
                <p> 2. Send amount to the given address. </p>
                <p> 3. After successful transaction, you get message on registerd mobile number and USDbPoints are added to your account.</p>
                </div>
                </p>
                <div class="form-group">
                    <label for="email">Amount:</label>
                    <input type="number" class="form-control" id="purchased_amount" name="purchased_amount" required="" placeholder='Enter an amount'>
                </div>
                <button type="button" class="btn btn-primary ss btn-s-xs" id="getAddress">Get Address</button>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12" id="address_details" style="display:none">
        <div class="row">
            <img class="img-responsive col-sm-2" src="https://www.coinpayments.net/qrgen.php?id=CPCG6GEESLAWUYLWHMENGGFYF5&key=64ae6c508a198fb0c78d480cdd12e808" id="qrcode_img" alt="Card Image" style="width:20% !important; margin: 0 auto;">
            <div class="col-sm-8">
                <div class="card-body">
                    <p class="card-text" style="margin: 1rem;font-weight:400">Send <strong>$<span id="amount_span" >79087698</span>  </strong></p>
                    <div class="alert alert-info" style="margin-bottom:0"><p class="card-text" style="margin: 1rem;font-weight:400"><span id="address_span">myxCVLurHBRT5QUdBPANLUb88dEV5usr1g</span></p></div>
                    <p class="card-text" style="margin:0 0 0 1rem;font-weight:400"><span class="card-text">Simply scan QR code with your mobile device or copy one in the input box</span></p>
                    <p class="card-text" ><a style="color:#2a6496;margin: 1rem;font-weight:400" id="status_url_span" target="blank" href=" https://www.coinpayments.net/index.php?cmd=status&id=CPCG6GEESLAWUYLWHMENGGFYF5&key=64ae6c508a198fb0c78d480cdd12e808">https://www.coinpayments.net/index.php?cmd=status&id=CPCG6GEESLAWUYLWHMENGGFYF5&key=64ae6c508a198fb0c78d480cdd12e808</a></p>
                </div>
            </div>
        </div>
    </div>
</div>  

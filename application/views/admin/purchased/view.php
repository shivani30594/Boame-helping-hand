  <section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">Payment Details</h3>
    <small>Verify the payment details of the user from here. If You found that payment is successfully done than click on confirm. It will add BPoints into account respectively.Enjoy!!</small>
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
      <form class="form-horizontal" data-validate="parsley" method="post" action="<?php echo BASE_URL;?>admin/purchased/confirm_payment" id="edit_profile_form">
        <input type="hidden" name="purchased_id" id="purchased_id" value="<?php echo isset($payment_details) ? $payment_details[0]->id : ''?>">
        <input type="hidden" name="purchased_amount" id="purchased_amount" value="">
        <section class="panel panel-default">
          <header class="panel-heading">
            <strong>Payment Details</strong>
          </header>
          <div class="panel-body">   
            <table class="table table-striped m-b-none">
              <tr>
                <td><b>FirstName</b></td>
                <td><?php echo isset($payment_details) ? $payment_details[0]->first_name : ''?></td>
              </tr>
              <tr>
                <td><b>LastName</b></td>
                <td><?php echo isset($payment_details) ? $payment_details[0]->last_name : ''?></td>
              </tr>
              <tr>
                <td><b>TransactionID</b></td>
                <td><?php echo isset($payment_details) ? $payment_details[0]->transaction_id : ''?></td>
              </tr>
              <tr>
                <td><b>Sender Name</b></td>
                <td><?php echo isset($payment_details) ? $payment_details[0]->sender_name : ''?></td>
              </tr>
              <tr>
                <td><b>Sender Number</b></td>
                <td><?php echo isset($payment_details) ? $payment_details[0]->sender_number : ''?></td>
              </tr>
              <tr>
                <td><b>Points Purchased</b></td>
                <td><?php echo isset($payment_details) ? $payment_details[0]->purchased_points : ''?></td>
              </tr>
            </table>
          </div>
          <footer class="panel-footer text-right bg-light lter">
            <button type="submit" class="btn btn-success btn-s-xs" <?php echo ($payment_details[0]->is_approved == 'pending' OR $payment_details[0]->is_approved == 'complete' OR $payment_details[0]->is_approved == 'cancel' ) ? 'disabled' : ''?>>Confirm</button>
          </footer>
        </section>
      </form>
    </div>  
</div>  
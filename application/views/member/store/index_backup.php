<section class="row m-b-md">
	<div class="col-sm-6">
	  <h3 class="m-b-xs text-black">Store</h3>
	  <small>Can't Wait? Get points instantly and Pledge more today!</small>
	</div>
</section>
<div class="alert alert-warning alert-block" id="select_checkbox" style="display:none">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4><i class="fa fa-bell-alt"></i>Warning!</h4>
    <p>Oops! Javascript to be disabled in your browser. You must have Javascript enabled in your browser to utilize the functionality of the website.</p>
  </div>
<div class="row">
    <div class="col-sm-4">
      <section class="panel panel-default">
        <header class="panel-heading">
          E-mall
        </header>
        <table class="table table-striped m-b-none text-center">
          <thead>
            <tr>
              <th width="5" class="text-center"><input type="checkbox" id="check_all" name="check_all" class="check_all"/></th>
              <th width="30" class="text-center">Item</th>                    
              <th width="70" class="text-center">GHS</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($store_details as $key => $value):?>
                  <tr> 
                    <td><input type="checkbox" id="check_selection" name="check_selection[]" class="check_selection" data-value="<?php echo $value->points?>"/></td>
                    <td class="text-center"><?php echo $value->points . ' bPoints' ?> </td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="#" class="btn btn-primary"> GHS <?php echo $value->points ?></a>
                      </div>
                    </td>
                  </tr> 
              <?php endforeach;?>              
          </tbody>
        </table>
      </section>
        <h4 style="border: 1px solid;border-radius: 27px;line-height: 33px;text-align: center;">Total Purchased Point: <span id="purchased_total"></span></h4>
        <div class="text-right">
        <form action="<?php echo BASE_URL?>member/purchased/purchased_points" method="post">
          <input type="hidden" id="purchased_input" name="purchased_input"/>
          <button class="btn btn-success" id="proceed_to_payment" disabled>Proceed For Payment</button>
        </form> 
        </div>
    </div>
    <div class="col-sm-8" style="box-shadow: 7px 7px 28px -5px rgba(79,82,70,1);">
     <header class="panel-heading">
        <h3>Purchased Point History</h3>
      </header>
    <div class="table-responsive">
      <table class="table table-striped m-b-none" id="purchased_history">
        <thead>
          <tr>
            <th>Id</th>
            <th>Transaction ID</th>
            <th>Purchased Points</th>
            <th>Purchased Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
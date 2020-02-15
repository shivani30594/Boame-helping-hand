<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">eWallet</h3>
    <small>Your bPoints and eWallet points are displayed over here!!</small>
  </div>
</section>
 <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
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
  <div class="col-lg-12">
    <section class="row m-l-none m-r-none m-b text-center box-shadow">
      <div class="col-xs-3 bg-primary dk lter r-l">
        <div class="wrapper">
          <i class="fa fa-gift fa fa-3x m-t m-b-sm text-white"></i>
          <p class="text-muted font-bold">GHS BPoints</p>
          <div class="h4 font-bold"><?php echo number_format((float)$result[0]['total_bpoints'], 2, '.', '') ;?></div>
        </div>
      </div>
      <div class="col-xs-3 bg-info lt">
        <div class="wrapper">
          <i class="far fa-money-bill-alt fa fa-3x m-t m-b-sm text-white"></i>
          <p class="text-muted font-bold">GHS eWallet</p>
          <div class="h4 font-bold">GHS <?php echo number_format((float)$result[0]['ewallet'], 2, '.', '');?></div>
        </div>
      </div>
      <div class="col-xs-3 bg-warning lt">
        <div class="wrapper">
          <i class="far fa-gift fa fa-3x m-t m-b-sm text-white"></i>
          <p class="text-muted font-bold">USD bPoints</p>
          <div class="h4 font-bold"> <?php echo number_format((float)$result[0]['total_bpoints_usd'], 2, '.', '');?></div>
        </div>
      </div>
      <div class="col-xs-3 bg-danger lt">
        <div class="wrapper">
          <i class="far fa-money-bill-alt fa fa-3x m-t m-b-sm text-white"></i>
          <p class="text-muted font-bold">USD eWallet</p>
          <div class="h4 font-bold">USD <?php echo number_format((float)$result[0]['ewallet_usd'], 2, '.', '');?></div>
        </div>
      </div>
    </section>
  </div>
</div>
<section class="panel panel-default" style="box-shadow: 10px 10px 9px -4px rgba(207,192,207,1);">
  <header class="panel-heading">
   <h4 class="">Point History</h4>
    <small class="">By referring you, many people earned commission points which are used to create the pledge. So, here is the list of users who earned points from you :</small>
  </header>
  <div class="table-responsive">
    <table class="table table-striped b-t b-light">
      <thead>
        <tr>
          <th class="text-left">Description</th>
          <th width="200px">Time remaining</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($log_history) > 0) : ?>
          <?php foreach($log_history as $key=>$value):?>
            <tr>
              <td class="text-left"><?php echo(unserialize($value['message'])['message'])?></td>
              <td width="200px"><?php echo get_timeago(strtotime($value['created']))?></td>
            </tr>
          <?php endforeach;?>
        <?php else:?>
          <tr>
            <td>No Records Found</td>
          </tr>
        <?php endif;?>
      </tbody>
    </table>
  </div>
  <footer class="panel-footer">
    <div class="row">
      <div id="pagination" class="col-sm-offset-4 text-right text-center-xs">
        <ul class="pagination pagination-sm m-t-none m-b-none">
            <?php foreach ($links as $link) {
                echo "<li>". $link."</li>";
            } ?>
        </ul>
      </div>
      <?php if ((isset($count)) && $count >= 1 ):?>
      <div class="col-sm-offset-4 text-right text-center-xs">                
        <ul class="pagination pagination-sm m-t-none m-b-none">
          <li><a class="btn" href="<?php echo BASE_URL?>ewallet_history/<?php echo $current_page-1?>" <?php echo (($current_page - 1) <= 0 ) ? "disabled" : ""?>><i class="fa fa-chevron-left"></i></a></li>
          <?php if(($count) <= 5 ): ?>
            <?php for ($i=0; $i<$count; $i++) { ?>
              <li><a class="btn" href="<?php echo BASE_URL?>ewallet_history/<?php echo $i+1?>"><?php echo $i+1?></a></li>
            <?php } ?>
          <?php elseif(($count) > 5 ): ?>
              <?php for ($i=0; $i<3; $i++) { ?>
                <li><a class="btn" href="<?php echo BASE_URL?>ewallet_history/<?php echo $i+1?>"><?php echo $i+1?></a></li>
              <?php } ?>
              <li><a class="btn">...</a></li>
              <?php for ($i=$count-3; $i<$count; $i++) { ?>
                <li><a class="btn" href="<?php echo BASE_URL?>ewallet_history/<?php echo $i+1?>"><?php echo $i+1?></a></li>
              <?php } ?>
          <?php endif;?>
          <!-- <?php for ($i=$start_page; $i<$end_page; $i++) { ?>
            <li><a class="btn" href="<?php echo BASE_URL?>ewallet_history/<?php echo $i+1?>"><?php echo $i+1?></a></li>
          <?php } ?> -->
          <li><a class="btn" href="<?php echo BASE_URL?>ewallet_history/<?php echo $current_page+1?>" <?php echo (($current_page + 1) == $count+1 ) ? "disabled" : ""?>><i class="fa fa-chevron-right"></i></a></li>
        </ul>
      </div>
    <?php endif; ?>
    </div>
  </footer>
</section>
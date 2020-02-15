<section class="row m-b-md">
  <div class="col-sm-6">
    <h3 class="m-b-xs text-black">Pledge Details</h3>
    <small>These are the two users paired with you who gives GHS100 within 7 days!!</small>
  </div>
</section>
<section class="hbox stretch">
  <aside class="aside-lg bg-light lter b-r">
    <section class="vbox">
      <section class="scrollable">
        <div class="wrapper">
          <section class="panel no-border bg-primary lt">
            <div class="panel-body">
              <div class="row m-t-xl">
                <div class="col-xs-6 col-xs-offset-3 text-center">
                  <div class="inline">
                    <div class="" data-percent="75" data-line-width="6" data-bar-color="#fff" data-track-color="#2796de" data-scale-color="false" data-size="140" data-line-cap="butt" data-animate="1000" style="width: 140px; height: 140px; line-height: 140px;">
                      <div class="thumb-lg avatar">
                        <img src="<?php echo $details[0]->picture?>" class="dker">
                      </div>
                    </div>
                    <div class="h4 m-t m-b-xs font-bold text-lt"><?php echo $details[0]->first_name . ' ' . $details[0]->last_name?></div>
                    <small class="text-muted m-b"></small>
                  </div>
                </div>
              </div>
              <div class="wrapper">
                <div class="row m-b">
                    <div class="col-xs-6 text-right">
                      <small>Title</small>
                      <div class="text-lt font-bold"><?php echo $details[0]->pledge_type ?></div>
                    </div>
                    <div class="col-xs-6">
                      <small>Description</small>
                      <div class="text-lt font-bold"><?php echo $details[0]->pledge_title?></div>
                    </div>
                  </div>
                  <div class="row m-b">
                    <div class="col-xs-6 text-right">
                      <small>Amount</small>
                      <div class="text-lt font-bold">GHS100</div>
                    </div>
                    <div class="col-xs-6">
                      <small>Created At </small>
                      <div class="text-lt font-bold"><?php echo date('d-M Y, H:i:s',strtotime($details[0]->created))?></div>
                    </div>
                  </div>
              </div>
            </div>
          </section>
        </div>
      </section>
    </section>
  </aside>
  <aside class="col-lg-4 b-l no-padder">
    <section class="vbox">
      <section class="scrollable">
        <div class="wrapper">
          <section class="panel panel-default">
           <header class="panel-heading">
                  <h3>Doners Listing</h3>
            </header>
            <section class="panel-body">
                <?php foreach ($matching_details as $key => $value) : ?>
             <!--    <?php echo "<pre>";print_r($value)?> -->
                  <?php $value->confirmed == 'Y' ? $class = 'success' : $class = 'danger'?>
                  <?php $value->confirmed == 'Y' ? $style = 'style="display:none"' : $style = ''?>
                    <article class="media">
                      <span class="pull-left thumb-sm"><img src="<?php echo $value->picture?>" class="img-circle"></span>
                      <div class="media-body">
                        <div class="pull-right media-xs text-center text-muted">
                         <h4>
                           <a class="btn btn-default" <?php echo $style?> href="<?php echo BASE_URL?>admin/pledge/confim_payment_of_pledge/<?php echo $value->pledge_log_id?>" data-toogle="tooltip" title="Payment Confirmation"><i class="fa fa-check"></i></a>
                         <h4>
                        </div>
                        <div class="h4"><?php echo $value->first_name . ' ' . $value->last_name ?></div>
                          <small class="block" style="padding:3px"><i class="fa fa-edit"></i><?php echo ' '.$value->pledge_type?></small>
                          <small class="block" style="padding:3px"><i class="fa fa-tasks"></i><?php echo ' '.$value->pledge_title?></small>
                          <small class="block" style="padding:3px"><i class="fa fa-phone"></i><?php echo ' +'.$value->mtn_mobile_number?></small>
                          <small class="block" style="padding:3px"><a href="#" class=""></a> <span class="label label-<?php echo $class?>"><?php echo $value->confirmed == 'Y' ? 'Completed' : 'Pending'?></span></small>
                        <?php if ($value->confirmed == 'N'):?>
                          <?php echo $value->end_date >= date('Y-m-d H:i:s') ? '<small style="padding:3px" class="label label-success">'.get_timeago_pledge(strtotime($value->end_date), time())."</span>" : '<small style="padding:3px" class="label label-danger">24 hours completed but still payment is not given by '.$value->first_name.' '.$value->last_name.'</span>'?></small>
                        <?php endif;?>
                        </div>
                    </article>
                    <br>
                <?php endforeach;?>
              </section>
          </section>
        </div>
      </section>
    </section>              
  </aside>
</section>

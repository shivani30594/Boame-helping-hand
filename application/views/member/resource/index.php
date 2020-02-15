<section class="row m-b-md">
  <div class="col-sm-12">
    <h3 class="m-b-xs text-black">Promotional Tools</h3>
    <small>All promotional tool can be displyed over here!</small>
  </div>
</section>
 <div class="col-md-12">
    <div class="panel-resource with-nav-tabs panel-info">
        <div class="panel-heading">
            <ul class="nav nav-tabs">
                <li class="active" style="width: 20%;"><a href="#link" data-toggle="tab" >Affilate Links</a></li>
                <li style="width: 20%;"><a href="#banner" data-toggle="tab">Banners</a></li>
                <li style="width: 20%;"><a href="#video" data-toggle="tab">Video Gallery</a></li>
                <li style="width: 20%;"><a href="#pdf" data-toggle="tab">PDF</a></li>
                <li style="width: 20%;"><a href="#ppt" data-toggle="tab">PPT</a></li>
                <li style="width: 20%;"><a href="#html" data-toggle="tab">HTML </a></li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="link" >
                  <div class="text-justify">
                    <h5>Referral Link</h5>
                    <div class="clear">
                        <small class="block text-muted" id="referral_link">https://boame.app.link/YWMYWplJ8N</small>
                        <button class="btn btn-xs btn-info m-t-xs" onclick="copyToClipboard('#referral_link')" id="copy_to_clipboard">Copy to clipboard</button>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="banner">
                    <?php if(isset($banners)):?>
                        <?php foreach ($banners as $banner) : ?>
                            <div class="text-justify col-md-3">
                                <img src="<?php echo ADMIN_RESOURCE.$banner->type.'/'.$banner->document_path?>" height="200px" width="200px" />
                                <div class="form-group">
                                    <a href="<?php echo ADMIN_RESOURCE.$banner->type.'/'.$banner->document_path?>" class="btn btn-primary" download>Download</a>
                                </div>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                <div class="tab-pane fade" id="video">
                   <div class="text-justify">
                    <?php if(isset($videos)):?>
                        <?php foreach ($videos as $video) : ?>
                            <video class="col-md-4" controls>
                                <source src="<?php echo ADMIN_RESOURCE.$video->type.'/'.$video->document_path?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php endforeach;?>
                    <?php endif;?>
                   </div>
                </div>
                <div class="tab-pane fade" id="pdf">
                  <div class="text-justify">
                    <?php if(isset($pdfs)):?>
                        <?php foreach ($pdfs as $pdf) : ?>
                            <div class="col-md-3">
                                <a href="<?php echo ADMIN_RESOURCE.$pdf->type.'/'.$pdf->document_path?>" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i><br> <?php echo $pdf->document_title?></a>
                            </div>  
                        <?php endforeach;?>
                    <?php endif;?>
                  </div>
                </div>
                <div class="tab-pane fade" id="ppt">
                  <div class="text-center">
                    <?php if(isset($ppts)):?>
                        <?php foreach ($ppts as $ppt) : ?>
                            <div class="col-md-3">
                                <a href="<?php echo ADMIN_RESOURCE.$ppt->type.'/'.$ppt->document_path?>" target="_blank"><i class="fa fa-file-powerpoint-o fa-5x"></i><br> <?php echo $ppt->document_title?></a>
                            </div>  
                        <?php endforeach;?>
                    <?php endif;?>
                  </div>
                </div>
                <div class="tab-pane fade" id="html">
                  <div class="text-left">
                    <?php if(isset($htmls)):?>
                        <?php foreach ($htmls as $html) : ?>
                            <div class="col-md-3">
                              <span class="html_title"><?php echo $html->document_title;?></span>
                            </div>
                            <div class="col-md-9">
                                <a href="<?php echo ADMIN_RESOURCE.$html->type.'/'.$html->document_path?>" target="_blank"> 
                                    <small class="block text-muted" id="html_link"><?php echo ADMIN_RESOURCE.$html->type.'/'.$html->document_path?></small>
                                </a>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('components/page_header'); ?>
<?php $this->load->view('components/page_sidebar'); ?>
<?php $this->load->view('components/page_footer'); ?>
        <section id="content">
          <section class="vbox">          
            <section class="scrollable wrapper">
             <?php $this->load->view($subview); ?>
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
      </section>
    </section>
  </section>
  <script src="<?php echo ADMIN_JS;?>jquery.min.js"></script>
  <script src="<?php echo ADMIN_JS;?>intlTelInput.js"></script>
  <script src="<?php echo ADMIN_JS;?>bootstrap.js"></script>
  <script src="<?php echo ADMIN_JS;?>app.js"></script>  
  <script src="<?php echo ADMIN_JS;?>slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?php echo ADMIN_JS;?>app.plugin.js"></script>
  <script src="<?php echo ADMIN_JS;?>jquery.validate.js"></script>
  <script src="<?php echo ADMIN_JS;?>datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ADMIN_JS;?>sweetalert2.min.js"></script>
  <script src="<?php echo ADMIN_JS;?>data.js"></script>
    
  <?php 
    if ($script)
    {
      $this->load->view($script);
    }
  ?>
  <?php $this->load->view('components/page_tail'); ?>
</body>
</html>
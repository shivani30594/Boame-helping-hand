<?php $this->load->view('components/admin_page_header'); ?>
<?php $this->load->view('components/admin_page_sidebar'); ?>
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
  <script>
      $("#phone").intlTelInput({
        // allowDropdown: false,
        // autoHideDialCode: false,
        // autoPlaceholder: "off",
        // dropdownContainer: "body",
        // excludeCountries: ["us"],
        // formatOnDisplay: false,
        // geoIpLookup: function(callback) {
        //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
        //     var countryCode = (resp && resp.country) ? resp.country : "";
        //     callback(countryCode);
        //   });
        // },
        // hiddenInput: "full_number",
        // initialCountry: "auto",
        // nationalMode: false,
        // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        // placeholderNumberType: "MOBILE",
        // preferredCountries: ['cn', 'jp'],
        // separateDialCode: true,
        utilsScript: "../../assets/js/utils.js"
      });
    </script>
<?php if(isset($script))
{
  $this->load->view($script);
}
?>
<?php $this->load->view('components/page_tail_admin'); ?>
</body>
</html>


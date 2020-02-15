<script>
    function copyToClipboard(element) 
    {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
        $("#copy_to_clipboard").text("Copied!");
        $("#copy_to_clipboard").removeClass("btn btn-info");
        $("#copy_to_clipboard").addClass("btn btn-success");
        setTimeout(
          	function() 
          	{
          		$("#copy_to_clipboard").text('Copy to clipboard');
          		$("#copy_to_clipboard").removeClass("btn btn-success");
          		$("#copy_to_clipboard").addClass("btn btn-info");
          	}, 1000);
    }

    function initiateCall() {
      jQuery.ajax({
          url : '<?php echo BASE_URL ?>'+'verification/callMethodJquery',
          method: 'post',
          dataType: 'json',
          data: {phone_number: $("#phone_number").intlTelInput("getNumber")},
          success: function(response){
            console.log(response);
            if (response == "true_number")
            {
              $("#alert_div").hide();
              showCodeForm(); 
            }
            else
            {
              $("#alert_div").show();
              $("#error_span").text("Please enter the valid phone number");
              $("#phone_number").val('');
            }
          },
           error: function (error) {
            console.log(error);
          }
      });
    }

    function showCodeForm() {
       $("#verify_code").show();
       $("#verify_code").fadeIn();
    }

    $(document).ready(function () 
    { 
        $("#phone_number").intlTelInput({
          hiddenInput: "full_number",
          utilsScript: "../../assets/js/utils.js"
        });
    }); 

    $(document).on('click', '#create', function() {
       window.location.replace('<?php echo BASE_URL?>create_pledge');
    });
    
    $(document).on('change',"#phone_number",function()
    {
       initiateCall();
    });

    
    $('#phone_number').keypress(function(e){ 
       if (this.value.length == 0 && e.which == 48 ){
          return false;
       }
    });

    $(document).on('change',"#verification_code",function()
    {
        jQuery.ajax({
          url : '<?php echo BASE_URL ?>'+'verify_message',
          method: 'post',
          dataType: 'json',
          data: {verification_code: $("#verification_code").val()},
          success: function(response)
          {
            if (response == 'true')
            {
                $("#verify_code").fadeOut();
                $("#verification_label").hide();
                jQuery.ajax({
                  url : '<?php echo BASE_URL ?>'+'edit_mtn',
                  method: 'post',
                  dataType: 'json',
                  data: {mtn_mobile_number: $("#phone_number").intlTelInput("getNumber")},
                  success: function(response){
                    $("#error_div").show();
                    if (response == "success")
                    {
                      $("#alert_div").hide();
                      $("#success_div").show();
                      $("#success_span").text("Your mobile number is verified successfully");
                    }
                    else
                    {
                      $("#alert_div").show();
                      $("#success_div").hide();
                      $("#error_span").text("Please try again later. Your MTN number is not verified.");
                    }
                  }
                  }); 
            }
            else
            {
              $("#alert_div").show();
              $("#success_div").hide();
              $("#error_span").text("Please enter the valid verification code");
            }
            //showVerifyForm();
          }
       });
    });

    $('[id^=detail-]').hide();
    $('.toggle').click(function() {
        $input = $( this );
        $target = $('#'+$input.attr('data-toggle'));
        $target.slideToggle();
    });

    jQuery.validator.addMethod('lettersonly', function(value, element) 
    {
          return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
    }, 'Letters only please'); 

    $('#edit_mtn_form').validate({
      rules: {
          mtn_account_number : { 
              required :true,
          },
           mtn_mobile_name : { 
              required :true,
          lettersonly : true
          }
      },
     messages: {
        mtn_account_number : {
           required : 'Please enter MTN account number'
        },
         mtn_mobile_name : {
           required : 'Please enter MTN account name',
           lettersonly: 'MTN account name contains only characters'
        }
     }
    });
    
    $(document).on('click', '#activate_eproduct_plan_a', function() {
        swal({
          title: 'Are you sure?',
          text: "You would like to Activate eProduct Plan. 150 BPoints will be deducted from your account.",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Activate!'
          }).then(function (result) {
          if( result == true){
              var total_bpoints = "<?php echo $bpoints;?>";
              if (total_bpoints >= 150)
              {    jQuery.ajax({
                      url : '<?php echo BASE_URL?>member/eproducts/activate_eproduct_plan',
                      success: function(response){
                        if (response == 1)
                        {
                          swal({
                              title: 'success',
                              text: "eProduct plan has been activated successfully!",
                              type: 'success',
                              allowOutsideClick: false
                            }).then(function (result) {
                                if( result == true){
                                window.location.href ="<?php echo BASE_URL?>eProducts";
                            }
                            });
                        }
                        else
                        {
                          swal("error","Something happens wrong!", "error");
                        }
                      }
                  });
              }
              else
              {
                swal("error", "You must have 150 BPoints to activate eProducts plan.", "error");
              }
          }
      });
    });

</script>
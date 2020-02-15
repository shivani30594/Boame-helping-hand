<script type="text/javascript">

    $(document).ready(function () 
    { 
        $("#phone_number").intlTelInput({
            hiddenInput: "full_number",
            utilsScript: "../../assets/js/utils.js"
        });
    });

	$(document).on('change',"#phone_number",function()
    {
		initiateCall();
    });
		
	jQuery.validator.addMethod('lettersonly', function(value, element) 
    {
  		return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
	}, 'Letters only please'); 

    $('#edit_profile_form').validate({
        rules: {
            first_name : { 
                required :true,
            lettersonly : true
            },
            last_name : { 
                required :true,
            lettersonly : true
            },
            email : { 
                required :true,
            }
        },
        messages: {
            first_name : {
               required : 'Please enter firstname',
               lettersonly : 'First name contains only characters',
            },
            last_name : {
               required : 'Please enter lastname',
               lettersonly : 'Last name contains only characters',
            },
            email : { 
                required : 'Please enter valid emailID',
            }
        }
    });

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

	function initiateCall() {
		//console.log("herer");
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
		//$("#verification_code").text(code);
		$("#verify_code").show();
		$("#verify_code").fadeIn();
		//$("#enter_number").fadeOut();
	}

	$(document).on('change',"#verification_code",function()
    {
		jQuery.ajax({
            url : '<?php echo BASE_URL ?>'+'verification/verifyMessageJquery',
            method: 'post',
            dataType: 'json',
            data: {verification_code: $("#verification_code").val()},
            success: function(response){
            	if (response == 'true')
            	{
					$("#verify_code").fadeOut();
            		$("#verification_label").hide();
            		jQuery.ajax({
			            url : '<?php echo BASE_URL ?>'+'member/profile/edit_mtn_detail_jquery',
			            method: 'post',
			            dataType: 'json',
			            data: {mtn_mobile_number: $("#phone_number").val()},
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

	// function checkStatus() {
	// 	jQuery.ajax({
 //            url : '<?php echo BASE_URL ?>'+'messageSending/statusCheckMethod',
 //            method: 'post',
 //            dataType: 'json',
 //            data: {phone_number : $("#phone_number").val()},
 //            success: function(response){
 //            	updateStatus(data.status);
 //            }
 //        });
	// }
	
	// function updateStatus(current) {
	// 	if (current === "unverified") {
	// 		$("#status").append(".");
	// 		setTimeout(checkStatus, 3000);
	// 	}
	// 	else {
	// 		success(); 
	// 	}
	// }
		
	// function success() {
	// 	$("#status").text("Verified!");
	// }
	</script>
<script>
  $(document).ready(function () 
    {  
      $('#setting_form').validate({
          rules: {
                merchant_id : { 
                  required :true,
                },
                public_key : { 
                    required :true,
                },
                private_key : { 
                    required :true,
                },
                secret_key : { 
                    required :true,
                },
                ghs_to_usd : { 
                    required :true,
                },
                usd_to_ghs : { 
                    required :true,
                },
                ipn_url : { 
                    required :true,
                },
            },
          messages: {
                merchant_id : {
                 required : 'Please enter Merchant Id',
                },
                public_key : {
                    required : 'Please enter Public Key',
                },
                private_key : {
                    required : 'Please enter Private Key',
                },
                secret_key : {
                    required : 'Please enter Secret Key',
                },
                ghs_to_usd : {
                    required : 'Please enter GHS to USD exchange rate',
                },
                usd_to_ghs : {
                    required : 'Please enter USD to GHS exchange rate',
                },
                ipn_url : {
                    required : 'Please enter IPN URL',
                },
            }
      });
    });
</script>
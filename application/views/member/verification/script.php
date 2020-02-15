<script>
    $(document).ready(function () 
    {
      $('#verify_code').validate({
          rules: {
              verification_code : { 
                  required :true,
              },
          },
          messages: {
              verification_code : {
                 required : 'Please enter valid verification code',
              },
          }
      });
       $('#enter_number').validate({
          rules: {
              phone_number : { 
                  required :true,
              },
          },
          messages: {
              phone_number : {
                 required : 'Please enter valid phone with you country code i.e.+919090909090',
              },
          }
      });
  });
    </script>
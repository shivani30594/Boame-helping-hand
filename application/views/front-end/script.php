<script>
$(document).ready(function()
{
    $('#contact_us_form').validate({
        rules: {
            name : { 
                required :true,
            },
            email : { 
                required :true
            },
            subject : { 
                required :true
            },
            message : { 
                required :true
            }
        },
        messages: {
            name : {
               required : 'Please enter name',
            },
            email : {
               required : 'Please enter emailID',
            },
            subject : {
               required : 'Please enter subject',
            },
            message : {
               required : 'Please enter the message',
            }
        }
    });
});
</script>
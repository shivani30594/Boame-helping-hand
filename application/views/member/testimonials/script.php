<script>
    $(document).ready(function () 
    {
      // $( "#edit_testimonial_form" ).submit(function( event ) {
      //   var messageLength = CKEDITOR.instances['message'].getData().replace(/<[^>]*>/gi, '').length;
      //     if( !messageLength ) {
      //         $("#ckeditor_required").show();
      //     }
      //     else{
      //       $("#ckeditor_required").hide();
      //     }
      // });
      $("#submitBtn").click(function(event){
            event.preventDefault();
            var messageLength = CKEDITOR.instances['message'].getData().replace(/<[^>]*>/gi, '').length;
            if(messageLength > 0)
              $("#edit_testimonial_form").submit();
            else
              $("#ckeditor_required").show();
      });
    });

    
</script>
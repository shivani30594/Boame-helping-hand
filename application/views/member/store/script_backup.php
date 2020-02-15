<script>
    $(document).ready(function () 
    {
    	$(document).on('change',"input[name='check_selection[]']",function()
	    {
	      	check_all(); //function call
	    });

    	// $(document).on('click',"#proceed_to_payment",function()
	    // {
	    //   	var total_count = $('.check_selection:checked').length;
	    //   	if (total_count < 1)
	    //   	{
	    //   		$("#select_checkbox").show();
	    //   	}
	    //   	else
	    //   	{
	    //   		$("#select_checkbox").hide();
	    //   	}
	    // });

        $('.check_selection').change(function () 
	    {
	        var checked_count = $('.check_selection:checked').length;
	        var total_count = $('.check_selection').length;
	        if (checked_count > 0)
	        {
	        	$("#proceed_to_payment").prop('disabled', false);
	        }
	        else
	        {
	        	$("#proceed_to_payment").prop('disabled', true);
	        }
	        if (total_count == checked_count) 
	        {
	             $(".check_all").prop("checked", true);
	            // $("#proceed_to_payment").prop('disabled', false);
	        }
	        else
	        {
	            $(".check_all").prop("checked", false);
	            //$("#proceed_to_payment").prop('disabled', true);
	        }
	    });

		$('.check_all').change(function ()
		{
			if (document.getElementById('check_all').checked) 
			{
			 	$(".check_selection").prop("checked", true);
			 	check_all(); // function call
	            $("#proceed_to_payment").prop('disabled', false);

			}
			else
			{
				$("#purchased_total").text('0')
				$("#purchased_input").val('0')
			 	$(".check_selection").prop("checked", false);
	            $("#proceed_to_payment").prop('disabled', true);

			}
		});

		// function
		function check_all()
		{
			var sList = 0;
			$("input[name='check_selection[]']").each(function () {
				if (this.checked)
				{
					var value = $(this).attr("data-value");
	      			sList = +sList + +value;
				}
			});
	      	 $("#purchased_total").text(sList);
	      	 $("#purchased_input").val(sList);
		}

		 $('#purchased_history').DataTable({
            "lengthMenu": [[10, 25, 50,100], [10, 25, 50,100]],
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "ajax":{
             "url": "<?php echo BASE_URL?>member/store/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                           },
            "columns": [
                  {
                    "width": 50,
                    "data": "id",
                  },
                  {
                    "width": 110,
                    "data": "transaction_id" 
                  },
                  {
                    "width": 110,
                    "data": "bpoints" 
                  },
                  {
                    "width": 100,
                   "data": "created" 
                  },
               ] 
        });
    });
</script>
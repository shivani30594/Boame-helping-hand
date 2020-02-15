<script>
    $(document).ready(function () 
    {
    	$(document).on('change',"input[name='amount_to_be_purchased']",function()
	    {
	    	$('#amount_span').html($(this).val());
	    	$("#amount_div").show();
	    });
		   
           table = $('#purchased_history').DataTable({
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
                    "width": 200,
                    "data": "amount" 
                  },
                  {
                    "width": 200,
                    "data": "created_at" 
                  },
                  {
                    "width": 100,
                   "render": function ( data, type, row, meta ) {
                   	if (row.status == 'pending')
                   	{
                   		return "<span class='label label-info'>Pending</span>";
                   	}
                   	else if (row.status == 'error')
                   	{
                   		return "<span class='label label-danger'>Error</span>";
                   	}
                    else if (row.status == 'declined')
                    {
                      return "<span class='label label-danger'>Cancel</span>";
                    }
                    else 
                    {
                      return "<span class='label label-success'>Complete</span>";
                    }
                   }
                  },
               ]
                 
        });
          
         /*  table.on('order.dt search.dt', function () {
           table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
               cell.innerHTML = i + 1;
           });
        }).draw();*/

          $(document).on('click', '#delete_btn', function() {
             var purchased_id = $(this).attr("data-purchasedid");
                swal({
                    title: 'Are you sure?',
                    text: "You would like to delete this request.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if(result == true){
                        jQuery.ajax({
                            url : '<?php echo BASE_URL?>member/store/delete',
                            method: 'post',
                            dataType: 'json',
                            data: {purchased_id: purchased_id},
                            success: function(response){
                              if (response.success == true)
                              {
                                swal("success", response.message, "success");
                              }
                              else
                              {
                                swal("error", response.message, "error");
                              }
                              table.ajax.reload();
                            }
                        });
                    }
                })
            });
 });
</script>
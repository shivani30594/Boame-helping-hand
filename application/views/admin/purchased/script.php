<script>
    $(document).ready(function () 
    {
       table = $('#purchased_request').DataTable({
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('offersDataTables', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('offersDataTables'));
            },
            "lengthMenu": [[10, 25, 50,100], [10, 25, 50,100]],
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "ajax":{
             "url": "<?php echo BASE_URL?>admin/purchased/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
            "columns": [
                  {
                    "width": 160,
                    "data": "first_name"
                  },
                  {
                    "width": 160,
                    "data": "last_name"
                  },
                  {
                    "width": 170,
                    "data": "refferal_code"
                  },
                  {
                    "width": 100,
                    "data": "amount",
                  },
                  {
                    "width": 200,
                    "data": "created_at",
                  },
                  {
                    "width": 120,
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
                  }
               ]
                 
        });
        $(".dataTables_length").addClass("col-sm-6");
        //confirmation
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
                    if( result == true){
                        jQuery.ajax({
                            url : '<?php echo BASE_URL?>admin/purchased/delete',
                            method: 'post',
                            dataType: 'json',
                            data: {purchased_id : purchased_id},
                            success: function(response){
                              console.log(response);
                              if (response.success == true)
                              {
                                table.ajax.reload();
                                swal("success", response.message, "success");
                              }
                              else
                              {
                                table.ajax.reload();
                                swal("error", response.message, "error");
                              }
                            }
                        });
                    }
                })
            });

    });
</script>
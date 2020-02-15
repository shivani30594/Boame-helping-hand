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
             "url": "<?php echo BASE_URL?>admin/purchased/cancel_admin_indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
            "columns": [
                  {
                    "width": 60,
                    "data": "id"
                  },
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
                    "data": "purchased_points",
                  },
                  {
                    "width": 150,
                    "data": "transaction_id",
                  },
                  {
                    "width": 120,
                    "render": function ( data, type, row, meta ) {
                      if (row.is_approved == 'pending')
                      {
                        return "<span class='label label-info'>Pending</span>"
                      }
                      else if (row.is_approved == 'in-progress')
                      {
                        return "<span class='label label-default'>In-progress</span>"
                      }
                      else if (row.is_approved == 'cancel' || row.is_approved == 'cancel_admin' || row.is_approved == 'cancel_system')
                      {
                        return "<span class='label label-danger'>Cancel</span>"
                      }
                      else
                      {
                        return "<span class='label label-success'>Complete</span>"
                      }
                    }
                  },
                  {
                    "width": 200,
                    "data": "purchased_date",
                  },
                  {
                    "width": 120,
                  },
               ] ,
                "columnDefs": [ {
                    "targets": 8,
                    "data": "download_link",
                    "orderable": false,
                    "render": function ( data, type, row, meta ) {
                      if (row.is_approved == 'complete' || row.is_approved == 'cancel' ||  row.is_approved == 'cancel_system' || row.is_approved == 'cancel_admin'|| row.is_approved == 'pending' )
                      {
                         style = "disabled";
                      }
                      else
                      {
                        style = '';
                      }
                      if (row.is_approved == 'complete' || row.is_approved == 'cancel_system' || row.is_approved == 'cancel_admin' || row.is_approved == 'cancel' )
                      {
                         stylee = "disabled";
                      }
                      else
                      {
                        stylee = '';
                      }
                      return '<a class="btn btn-sm btn-icon btn-warning" href="<?php echo BASE_URL?>admin/purchased/view/'+row.id+'" data-toggle="tooltip" title="View Payment Details"><i class="fa fa-eye"></i></a>';
                     }
                } ] ,
                 
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
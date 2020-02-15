<script>
    $(document).ready(function () 
    {
       table = $('#withdrawal_request').DataTable({
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
             "url": "<?php echo BASE_URL?>admin/withdraw/pending_indexjson",
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
                    "width": 130,
                    "data": "first_name"
                  },
                  {
                    "width": 130,
                    "data": "last_name"
                  },
                  {
                    "width": 160,
                    "data": "mtn_mobile_number"
                  },
                  {
                    "width": 160,
                    "data": "mtn_mobile_name"
                  },
                  {
                    "width": 140,
                    "data": "withdraw_amount",
                  },
                  {
                    "width": 140,
                    "data": "received_amount"
                  },
                  {
                    "width": 100,
                    "render": function ( data, type, row, meta ) {
                      if (row.is_withdraw == 'pending')
                      {
                        return "<span class='label label-info'>Pending</span>"
                      }
                      else if (row.is_withdraw == 'cancel')
                      {
                        return "<span class='label label-danger'>Cancel</span>"
                      }
                      else
                      {
                        return "<span class='label label-success'>Complete</span>"
                      }
                    },
                  },
                  {
                    "width": 150,
                    "data": "withdraw_date",
                  },
                  {
                    "width": 120,
                  },
               ] ,
                "columnDefs": [ {
                    "targets": 9,
                    "data": "download_link",
                    "orderable": false,
                    "render": function ( data, type, row, meta ) {
                      if (row.is_withdraw != 'pending')
                      {
                         style = "disabled";
                      }
                      else
                      {
                        style = '';
                      }
                      return '<a class="btn btn-sm btn-icon btn-primary" '+style+' href="<?php echo BASE_URL?>admin/withdraw/confirm/'+row.id+'" data-toggle="tooltip" title="Confirm Request"><i class="fa fa-check"></i></a>\
                              <a class="btn btn-sm btn-icon btn-danger " '+style+' id="delete_btn" data-withdrawid='+row.id+' data-toggle="tooltip" title="Cancel Request"><i class="fa fa-close"></i></a>';
                    }
                } ] ,
                 
                 
        });
        $(".dataTables_length").addClass("col-sm-6");
        //confirmation
         $(document).on('click', '#delete_btn', function() {
             var withdraw_id = $(this).attr("data-withdrawid");
                swal({
                    title: 'Are you sure?',
                    text: "You would like to cancel this request.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then(function (result) {
                    if( result == true){
                        jQuery.ajax({
                            url : '<?php echo BASE_URL?>admin/withdraw/cancel',
                            method: 'post',
                            dataType: 'json',
                            data: {withdraw_id : withdraw_id},
                            success: function(response){
                              console.log(response);
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
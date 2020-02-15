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
             "url": "<?php echo BASE_URL?>member/buy_usd/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
            "columns": [
                  {
                    "width": 220,
                    "data": "transaction_id" 
                  },
                  {
                    "width": 220,
                    "data": "address" 
                  },
                  {
                    "width": 150,
                    "data": "amount" 
                  },
                  {
                    "width": 100,
                   "render": function ( data, type, row, meta ) {
                   	if (row.status == 'pending')
                   	{
                   		return "<span class='label label-info'>Pending</span>";
                   	}
                   	else if (row.status == 'in_progress')
                   	{
                   		return "<span class='label label-primary'>In Progress</span>";
                   	}
                    else if (row.status == 'cancel')
                    {
                      return "<span class='label label-danger'>Cancel</span>";
                    }
                    else 
                    {
                      return "<span class='label label-success'>Complete</span>";
                    }
                   }
                  },
                  {
                    "width": 200,
                    "data": "created" 
                  },
                  {
                    "width": 200,
                    "data": "payment_date" 
                  },
                  {
                    "width": 30,
                  },
               ],
               "columnDefs": [ {
                    "targets": 6,
                    "data": "download_link",
                    "orderable": false,
                    "render": function ( data, type, row, meta ) {
                      return '<a class="btn btn-sm btn-icon btn-primary" href="<?php echo BASE_URL?>view_address/'+row.id+'" data-toggle="tooltip" title="View Transaction Details"><i class="fa fa-eye"></i></a>';
                    }
                } ] ,
                 
        });
          
         /*  table.on('order.dt search.dt', function () {
           table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
               cell.innerHTML = i + 1;
           });
        }).draw();*/
            $(document).on('click', '#getAddress', function() {
                jQuery.ajax({
                    url : '<?php echo BASE_URL?>call_coinpayment_api',
                    method: 'post',
                    dataType: 'json',
                    data : {purchased_bpoints : $("#purchased_amount").val() },
                    success: function(response) {
                       if (response.result != '' || response.result != undefined  )
                       {
                          $("#amount_span").text(response.result.amount);
                          $("#status_url_span").attr('href',response.result.status_url);
                          $("#status_url_span").html(response.result.status_url);
                          $("#qrcode_img").attr('src',response.result.qrcode_url);
                          $("#address_span").text(response.result.address);
                          $("#address_details").show();
                          $("#purchased_amount").val();
                       }
                    }
                });
            });

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